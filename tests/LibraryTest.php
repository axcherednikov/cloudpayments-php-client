<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use Excent\Cloudpayments\Library;
use Excent\Cloudpayments\Request\ApplepayStartSession;
use Excent\Cloudpayments\Request\CardsPayment;
use Excent\Cloudpayments\Request\CardsTopUp;
use Excent\Cloudpayments\Request\KktReceipt;
use Excent\Cloudpayments\Request\NotificationsGet;
use Excent\Cloudpayments\Request\NotificationsUpdate;
use Excent\Cloudpayments\Request\OrderCancel;
use Excent\Cloudpayments\Request\OrderCreate;
use Excent\Cloudpayments\Request\PaymentsConfirm;
use Excent\Cloudpayments\Request\PaymentsFind;
use Excent\Cloudpayments\Request\PaymentsGet;
use Excent\Cloudpayments\Request\PaymentsList;
use Excent\Cloudpayments\Request\PaymentsRefund;
use Excent\Cloudpayments\Request\PaymentsVoid;
use Excent\Cloudpayments\Request\Post3DS;
use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;
use Excent\Cloudpayments\Request\SubscriptionCancel;
use Excent\Cloudpayments\Request\SubscriptionCreate;
use Excent\Cloudpayments\Request\SubscriptionFind;
use Excent\Cloudpayments\Request\SubscriptionGet;
use Excent\Cloudpayments\Request\SubscriptionUpdate;
use Excent\Cloudpayments\Request\TokenList;
use Excent\Cloudpayments\Request\TokenPayment;
use Excent\Cloudpayments\Request\TokenTopUp;
use Excent\Cloudpayments\Response\AppleSessionResponse;
use Excent\Cloudpayments\Response\CloudResponse;
use Excent\Cloudpayments\Response\KktReceiptResponse;
use Excent\Cloudpayments\Response\NotificationResponse;
use Excent\Cloudpayments\Response\OrderResponse;
use Excent\Cloudpayments\Response\SubscriptionArrayResponse;
use Excent\Cloudpayments\Response\SubscriptionResponse;
use Excent\Cloudpayments\Response\TokenArrayResponse;
use Excent\Cloudpayments\Response\TransactionArrayResponse;
use Excent\Cloudpayments\Response\TransactionResponse;
use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use Excent\Cloudpayments\Tests\Support\HttpClientLibrary;
use Excent\Cloudpayments\Tests\Support\HttpRequestLog;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @group Cloudpayments
 */
final class LibraryTest extends TestCase
{
    /**
     * @dataProvider apiMethodsProvider
     *
     * @param  callable(): (object|null)    $requestFactory
     * @param  array<string, mixed>         $expectedData
     * @param  array<string, mixed>         $responsePayload
     * @param  class-string<CloudResponse>  $responseClass
     *
     * @throws JsonException
     */
    public function testApiMethodsSendExpectedRequests(
        string $apiMethod,
        string $cloudMethod,
        callable $requestFactory,
        array $expectedData,
        array $responsePayload,
        string $responseClass
    ): void {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse($this->jsonResponse($responsePayload));

        $request = $requestFactory();
        $result = $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);

        $this->assertInstanceOf($responseClass, $result);
        $this->assertTrue($result->success);
        $this->assertSame($cloudMethod, $library->lastMethod);
        $this->assertEquals($expectedData, $library->lastPostData);
    }

    public function testTestMethodSendsEmptyRequestAndFillsCloudResponse(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse($this->jsonResponse(['Success' => true, 'Message' => 'ok']));

        $result = $library->test();

        $this->assertInstanceOf(CloudResponse::class, $result);
        $this->assertTrue($result->success);
        $this->assertSame('ok', $result->message);
        $this->assertSame('test', $library->lastMethod);
        $this->assertSame([], $library->lastPostData);
    }

    public function testGettersReturnConstructorValues(): void
    {
        $library = new Library('public_id', 'password', 'https://example.com/');

        $this->assertSame('public_id', $library->getPublicId());
        $this->assertSame('password', $library->getPass());
        $this->assertSame('https://example.com/', $library->getUrl());
    }

    public function testSendRequestUsesFormParams(): void
    {
        $library = new HttpClientLibrary('public_id', 'password');
        $response = new Response(200);
        $requestLog = new HttpRequestLog();
        $library->replaceClient($this->recordingClient($requestLog, $response));

        $this->assertSame($response, $library->sendRequest('payments/get', ['TransactionId' => 10]));
        $this->assertSame('POST', $requestLog->method);
        $this->assertSame('/payments/get', $requestLog->path);
        $this->assertSame(['TransactionId' => '10'], $requestLog->formParams);
        $this->assertArrayNotHasKey('X-Request-ID', $requestLog->headers);
    }

    public function testSendRequestUsesCustomIdempotencyKey(): void
    {
        $library = new HttpClientLibrary('public_id', 'password');
        $library->setIdempotencyKey('request-key');

        $response = new Response(200);
        $requestLog = new HttpRequestLog();
        $library->replaceClient($this->recordingClient($requestLog, $response));

        $this->assertSame($response, $library->sendRequest('payments/confirm', ['TransactionId' => 10]));
        $this->assertSame('/payments/confirm', $requestLog->path);
        $this->assertSame(['TransactionId' => '10'], $requestLog->formParams);
        $this->assertSame(['request-key'], $requestLog->headers['X-Request-ID']);
    }

    public function testSendRequestGeneratesIdempotencyKey(): void
    {
        $library = new HttpClientLibrary('public_id', 'password');
        $library->setIdempotency(true);

        $postData = ['TransactionId' => 10, 'Amount' => 20];
        $response = new Response(200);
        $requestLog = new HttpRequestLog();
        $library->replaceClient($this->recordingClient($requestLog, $response));

        $this->assertSame($response, $library->sendRequest('payments/confirm', $postData));
        $this->assertSame(['TransactionId' => '10', 'Amount' => '20'], $requestLog->formParams);
        $this->assertSame(
            [$library->getRequestId('payments/confirm', $postData)],
            $requestLog->headers['X-Request-ID']
        );
    }

    public function testGetRequestIdIsDeterministic(): void
    {
        $library = new Library('public_id', 'password');
        $postData = ['Amount' => 10, 'JsonData' => ['key' => 'value']];

        $this->assertSame(
            md5('method:payments/refund;Amount:' . serialize(10) . 'JsonData:' . serialize(['key' => 'value'])),
            $library->getRequestId('payments/refund', $postData)
        );
    }

    /**
     * @return array<string, array{
     *     0: string,
     *     1: string,
     *     2: callable(): (object|null),
     *     3: array<string, mixed>,
     *     4: array<string, mixed>,
     *     5: class-string<CloudResponse>
     * }>
     */
    public static function apiMethodsProvider(): array
    {
        return [
            'getPaymentData' => [
                'getPaymentData',
                'payments/get',
                static fn (): PaymentsGet => new PaymentsGet(1),
                ['TransactionId' => 1],
                ['Success' => true, 'Model' => ['TransactionId' => 504, 'Amount' => 10.0]],
                TransactionResponse::class,
            ],
            'getPaymentDataByInvoice' => [
                'getPaymentDataByInvoice',
                'payments/find',
                static fn (): PaymentsFind => new PaymentsFind('invoice-1'),
                ['InvoiceId' => 'invoice-1'],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'createPaymentByCard2Step' => [
                'createPaymentByCard2Step',
                'payments/cards/auth',
                static fn (): CardsPayment => new CardsPayment(10, 'RUB', '127.0.0.1', 'cryptogram'),
                ['Amount' => 10, 'Currency' => 'RUB', 'IpAddress' => '127.0.0.1', 'CardCryptogramPacket' => 'cryptogram'],
                self::transactionPayload(),
                TransactionWith3dsResponse::class,
            ],
            'createPaymentByToken2Step' => [
                'createPaymentByToken2Step',
                'payments/tokens/auth',
                static fn (): TokenPayment => new TokenPayment(100, 'RUB', 'account', 'token'),
                [
                    'Amount' => 100,
                    'Currency' => 'RUB',
                    'AccountId' => 'account',
                    'Token' => 'token',
                    'PaymentScheduled' => 0,
                    'TrInitiatorCode' => 1,
                ],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'post3Ds' => [
                'post3Ds',
                'payments/cards/post3ds',
                static fn (): Post3DS => new Post3DS(10, 'pares'),
                ['TransactionId' => 10, 'PaRes' => 'pares'],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'executePaymentByToken' => [
                'executePaymentByToken',
                'payments/tokens/charge',
                static fn (): TokenPayment => new TokenPayment(10, 'RUB', 'account', 'token'),
                [
                    'Amount' => 10,
                    'Currency' => 'RUB',
                    'AccountId' => 'account',
                    'Token' => 'token',
                    'PaymentScheduled' => 0,
                    'TrInitiatorCode' => 1,
                ],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'confirmPayment' => [
                'confirmPayment',
                'payments/confirm',
                static fn (): PaymentsConfirm => new PaymentsConfirm(10, 20, '{"key":"value"}'),
                ['Amount' => 10, 'JsonData' => '{"key":"value"}', 'TransactionId' => 20],
                self::successPayload(),
                CloudResponse::class,
            ],
            'getListPayment' => [
                'getListPayment',
                'payments/list',
                static fn (): PaymentsList => new PaymentsList('2024-01-01', 'MSK'),
                ['Date' => '2024-01-01', 'TimeZone' => 'MSK'],
                ['Success' => true, 'Model' => [['TransactionId' => 1]]],
                TransactionArrayResponse::class,
            ],
            'cancelPayment' => [
                'cancelPayment',
                'payments/void',
                static fn (): PaymentsVoid => new PaymentsVoid(10),
                ['TransactionId' => 10],
                self::successPayload(),
                CloudResponse::class,
            ],
            'startSession' => [
                'startSession',
                'applepay/startsession',
                static fn (): ApplepayStartSession => new ApplepayStartSession('https://apple-pay-gateway.apple.com/paymentservices/startSession'),
                ['ValidationUrl' => 'https://apple-pay-gateway.apple.com/paymentservices/startSession'],
                ['Success' => true, 'Model' => ['nonce' => 'd6358e06']],
                AppleSessionResponse::class,
            ],
            'createReceipt' => [
                'createReceipt',
                'kkt/receipt',
                static fn (): KktReceipt => new KktReceipt('1234567890', 'Income', new CustomerReceipt([])),
                ['Inn' => '1234567890', 'Type' => 'Income', 'CustomerReceipt' => ['Items' => []]],
                ['Success' => true, 'Model' => ['Id' => 'receipt-id', 'ErrorCode' => 0]],
                KktReceiptResponse::class,
            ],
            'paymentsRefund' => [
                'paymentsRefund',
                'payments/refund',
                static fn (): PaymentsRefund => new PaymentsRefund(10, 20),
                ['TransactionId' => 10, 'Amount' => 20.0],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'paymentsCardsCharge' => [
                'paymentsCardsCharge',
                'payments/cards/charge',
                static fn (): CardsPayment => new CardsPayment(10, 'RUB', '127.0.0.1', 'cryptogram'),
                ['Amount' => 10, 'Currency' => 'RUB', 'IpAddress' => '127.0.0.1', 'CardCryptogramPacket' => 'cryptogram'],
                self::transactionPayload(),
                TransactionWith3dsResponse::class,
            ],
            'paymentsCardsTopup' => [
                'paymentsCardsTopup',
                'payments/cards/topup',
                self::cardsTopUp(...),
                [
                    'Name' => 'Card Holder',
                    'CardCryptogramPacket' => 'cryptogram',
                    'Amount' => 10,
                    'AccountId' => 'account',
                    'Currency' => 'RUB',
                ],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'paymentsTokenTopup' => [
                'paymentsTokenTopup',
                'payments/token/topup',
                self::tokenTopUp(...),
                ['Token' => 'token', 'Amount' => 10, 'AccountId' => 'account', 'Currency' => 'RUB'],
                self::transactionPayload(),
                TransactionResponse::class,
            ],
            'paymentsTokensList' => [
                'paymentsTokensList',
                'payments/tokens/list',
                static fn (): ?TokenList => null,
                [],
                ['Success' => true, 'Model' => [['Token' => 'token']]],
                TokenArrayResponse::class,
            ],
            'subscriptionsCreate' => [
                'subscriptionsCreate',
                'subscriptions/create',
                static fn (): SubscriptionCreate => new SubscriptionCreate(),
                [],
                ['Success' => true, 'Model' => ['Id' => 'sub-id']],
                SubscriptionResponse::class,
            ],
            'subscriptionsGet' => [
                'subscriptionsGet',
                'subscriptions/get',
                self::subscriptionGet(...),
                ['Id' => 'sub-id'],
                ['Success' => true, 'Model' => ['Id' => 'sub-id']],
                SubscriptionResponse::class,
            ],
            'subscriptionsFind' => [
                'subscriptionsFind',
                'subscriptions/find',
                static fn (): SubscriptionFind => new SubscriptionFind(),
                [],
                ['Success' => true, 'Model' => [['Id' => 'sub-id']]],
                SubscriptionArrayResponse::class,
            ],
            'subscriptionsUpdate' => [
                'subscriptionsUpdate',
                'subscriptions/update',
                self::subscriptionUpdate(...),
                ['Id' => 'sub-id', 'Description' => 'description'],
                ['Success' => true, 'Model' => ['Id' => 'sub-id']],
                SubscriptionResponse::class,
            ],
            'subscriptionsCancel' => [
                'subscriptionsCancel',
                'subscriptions/cancel',
                self::subscriptionCancel(...),
                ['Id' => 'sub-id'],
                self::successPayload(),
                CloudResponse::class,
            ],
            'ordersCreate' => [
                'ordersCreate',
                'orders/create',
                static fn (): OrderCreate => new OrderCreate(1, 'RUB', 'description'),
                ['Amount' => 1, 'Currency' => 'RUB', 'Description' => 'description'],
                ['Success' => true, 'Model' => ['Id' => 'order-id']],
                OrderResponse::class,
            ],
            'ordersCancel' => [
                'ordersCancel',
                'orders/cancel',
                self::orderCancel(...),
                ['Id' => 'order-id'],
                self::successPayload(),
                CloudResponse::class,
            ],
            'siteNotificationsGet' => [
                'siteNotificationsGet',
                'site/notifications/pay/get',
                self::notificationsGet(...),
                ['Type' => 'pay'],
                ['Success' => true, 'Model' => ['Address' => 'https://example.com/hook']],
                NotificationResponse::class,
            ],
            'siteNotificationsUpdate' => [
                'siteNotificationsUpdate',
                'site/notifications/pay/update',
                self::notificationsUpdate(...),
                ['Type' => 'pay', 'IsEnabled' => 'true', 'Address' => 'https://example.com/hook'],
                self::successPayload(),
                CloudResponse::class,
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     *
     * @throws JsonException
     */
    private function jsonResponse(array $payload): Response
    {
        return new Response(200, ['Content-type' => 'application/json'], json_encode($payload, JSON_THROW_ON_ERROR));
    }

    private function recordingClient(HttpRequestLog $requestLog, Response $response): Client
    {
        return new Client([
            'base_uri' => 'https://api.cloudpayments.ru/',
            'handler' => static function (RequestInterface $request) use ($requestLog, $response) {
                $requestLog->method = $request->getMethod();
                $requestLog->path = $request->getUri()->getPath();
                $requestLog->headers = $request->getHeaders();

                /** @var array<int|string, mixed> $formParams */
                $formParams = [];
                parse_str((string) $request->getBody(), $formParams);
                $requestLog->formParams = $formParams;

                return Create::promiseFor($response);
            },
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private static function transactionPayload(): array
    {
        return ['Success' => true, 'Model' => ['TransactionId' => 1]];
    }

    /**
     * @return array<string, mixed>
     */
    private static function successPayload(): array
    {
        return ['Success' => true, 'Message' => 'ok'];
    }

    private static function cardsTopUp(): CardsTopUp
    {
        $request = new CardsTopUp();
        $request->name = 'Card Holder';
        $request->cardCryptogramPacket = 'cryptogram';
        $request->amount = 10;
        $request->accountId = 'account';
        $request->currency = 'RUB';

        return $request;
    }

    private static function tokenTopUp(): TokenTopUp
    {
        $request = new TokenTopUp();
        $request->token = 'token';
        $request->amount = 10;
        $request->accountId = 'account';
        $request->currency = 'RUB';

        return $request;
    }

    private static function subscriptionGet(): SubscriptionGet
    {
        $request = new SubscriptionGet();
        $request->id = 'sub-id';

        return $request;
    }

    private static function subscriptionUpdate(): SubscriptionUpdate
    {
        $request = new SubscriptionUpdate();
        $request->id = 'sub-id';
        $request->description = 'description';

        return $request;
    }

    private static function subscriptionCancel(): SubscriptionCancel
    {
        $request = new SubscriptionCancel();
        $request->id = 'sub-id';

        return $request;
    }

    private static function orderCancel(): OrderCancel
    {
        $request = new OrderCancel();
        $request->id = 'order-id';

        return $request;
    }

    private static function notificationsGet(): NotificationsGet
    {
        $request = new NotificationsGet();
        $request->type = 'pay';

        return $request;
    }

    private static function notificationsUpdate(): NotificationsUpdate
    {
        $request = new NotificationsUpdate();
        $request->type = 'pay';
        $request->isEnabled = true;
        $request->address = 'https://example.com/hook';

        return $request;
    }
}
