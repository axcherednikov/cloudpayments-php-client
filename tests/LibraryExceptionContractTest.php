<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use DateTimeImmutable;
use Error;
use Excent\Cloudpayments\Enum\Currency;
use Excent\Cloudpayments\Enum\SbpScheme;
use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Library;
use Excent\Cloudpayments\Request\ChargebacksList;
use Excent\Cloudpayments\Request\CloudpaymentsData;
use Excent\Cloudpayments\Request\PaymentsFind;
use Excent\Cloudpayments\Request\PaymentsListV2;
use Excent\Cloudpayments\Request\SbpLink;
use Excent\Cloudpayments\Response\CloudResponse;
use Excent\Cloudpayments\Response\TransactionArrayResponse;
use Excent\Cloudpayments\Response\TransactionResponse;
use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use Excent\Cloudpayments\Tests\Support\HttpClientLibrary;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Throwable;

final class LibraryExceptionContractTest extends TestCase
{
    public function testEveryPublicApiMethodDeclaresThrowable(): void
    {
        $coveredMethods = array_keys(self::apiMethodsProvider());
        $apiMethods = [];

        foreach ((new ReflectionClass(Library::class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $returnType = $method->getReturnType();

            if (! $returnType instanceof ReflectionNamedType || ! is_a($returnType->getName(), CloudResponse::class, true)) {
                continue;
            }

            $apiMethods[] = $method->getName();
            $doc = $method->getDocComment();
            $this->assertIsString($doc, $method->getName());
            preg_match_all('/@throws\s+(\S+)/', $doc, $matches);
            $expected = ['Throwable'];

            $this->assertSame($expected, $matches[1], $method->getName());
        }

        sort($apiMethods);
        sort($coveredMethods);
        $this->assertSame($apiMethods, $coveredMethods, 'Exercise every public API method.');
    }

    public function testRequestBoundariesDeclareThrowable(): void
    {
        foreach (['request', 'sendRequest'] as $name) {
            $doc = (new ReflectionMethod(Library::class, $name))->getDocComment();
            $this->assertIsString($doc);
            $this->assertStringContainsString('@throws Throwable', $doc);
        }
    }

    /**
     * @dataProvider apiMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testTransportExceptionReachesCaller(string $apiMethod, callable $requestFactory): void
    {
        $exception = new ConnectException('Connection failed', new Request('POST', '/test'));
        $library = $this->libraryWith($exception);
        $request = $requestFactory();

        try {
            $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);
        } catch (Throwable $actual) {
            $this->assertSame($exception, $actual);

            return;
        }

        $this->fail('The original transport exception must reach the caller.');
    }

    /**
     * @dataProvider apiMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testNativeErrorReachesCaller(string $apiMethod, callable $requestFactory): void
    {
        $error = new Error('HTTP handler failed');
        $library = new HttpClientLibrary('public_id', 'password');
        $library->replaceClient(new Client([
            'base_uri' => Library::DEFAULT_URL,
            'handler' => static function () use ($error): never {
                throw $error;
            },
        ]));
        $request = $requestFactory();

        try {
            $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);
        } catch (Throwable $actual) {
            $this->assertSame($error, $actual);

            return;
        }

        $this->fail('The original native error must reach the caller.');
    }

    /**
     * @dataProvider apiMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testHttpExceptionReachesCaller(string $apiMethod, callable $requestFactory): void
    {
        $library = $this->libraryWith(new Response(500));
        $request = $requestFactory();
        $this->expectException(ServerException::class);
        $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);
    }

    /**
     * @dataProvider apiMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testInvalidJsonReachesCaller(string $apiMethod, callable $requestFactory): void
    {
        $library = $this->libraryWith(new Response(200, [], '{invalid json'));
        $request = $requestFactory();
        $this->expectException(JsonException::class);
        $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);
    }

    /**
     * @dataProvider transactionMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testInvalidTransactionModelReachesCaller(string $apiMethod, callable $requestFactory): void
    {
        $model = (new ReflectionMethod(Library::class, $apiMethod))->getReturnType();
        $isList = $model instanceof ReflectionNamedType && $model->getName() === TransactionArrayResponse::class;
        $body = $isList
            ? '{"Success":false,"Model":[{"TransactionId":"invalid"}]}'
            : '{"Success":false,"Model":{"TransactionId":"invalid"}}';
        $library = $this->libraryWith(new Response(200, [], $body));
        $request = $requestFactory();
        $this->expectException(ResponseFormatException::class);
        $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);
    }

    /**
     * @dataProvider apiMethodsProvider
     *
     * @param callable(): (object|null) $requestFactory
     */
    public function testApiRejectionRemainsAResponse(string $apiMethod, callable $requestFactory): void
    {
        $library = $this->libraryWith(new Response(200, [], '{"Success":false,"Message":"Declined","ErrorCode":5}'));
        $request = $requestFactory();
        $response = $request === null ? $library->{$apiMethod}() : $library->{$apiMethod}($request);

        $this->assertInstanceOf(CloudResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertSame('Declined', $response->message);
        $this->assertSame(5, $response->errorCode);
    }

    public function testSbpJsonSerializationExceptionReachesCallerBeforeHttpRequest(): void
    {
        $handler = new MockHandler([]);
        $library = new HttpClientLibrary('public_id', 'password');
        $library->replaceClient(new Client(['handler' => HandlerStack::create($handler)]));
        $request = new SbpLink('10.00', Currency::RUB, SbpScheme::CHARGE, jsonData: new CloudpaymentsData(additionalData: ['invalid' => NAN]));
        $this->expectException(JsonException::class);
        $library->paymentsQrSbpLink($request);
    }

    /**
     * @return array<string, array{string, callable(): (object|null)}>
     */
    public static function apiMethodsProvider(): array
    {
        $methods = [];

        foreach (LibraryTest::apiMethodsProvider() as $name => $case) {
            $methods[$name] = [$case[0], $case[2]];
        }

        $methods['getPaymentDataByInvoiceV2'] = ['getPaymentDataByInvoiceV2', static fn (): PaymentsFind => new PaymentsFind('invoice')];
        $methods['getListPaymentV2'] = ['getListPaymentV2', static fn (): PaymentsListV2 => new PaymentsListV2(new DateTimeImmutable('2026-10-01'), new DateTimeImmutable('2026-10-02'), 1)];
        $methods['chargebacksList'] = ['chargebacksList', static fn (): ChargebacksList => new ChargebacksList(new DateTimeImmutable('2026-10-01'), new DateTimeImmutable('2026-10-02'), 1)];
        $methods['paymentsQrSbpLink'] = ['paymentsQrSbpLink', static fn (): SbpLink => new SbpLink('10.00', Currency::RUB, SbpScheme::CHARGE)];
        $methods['paymentsQrSbpImage'] = ['paymentsQrSbpImage', static fn (): SbpLink => new SbpLink('10.00', Currency::RUB, SbpScheme::CHARGE)];
        $methods['sbpV2BanksInfo'] = ['sbpV2BanksInfo', static fn (): ?object => null];
        $methods['test'] = ['test', static fn (): ?object => null];

        return $methods;
    }

    /**
     * @return array<string, array{string, callable(): (object|null)}>
     */
    public static function transactionMethodsProvider(): array
    {
        return array_filter(self::apiMethodsProvider(), static fn (array $case): bool => self::hasTransactionModel($case[0]));
    }

    private static function hasTransactionModel(string $apiMethod): bool
    {
        $returnType = (new ReflectionMethod(Library::class, $apiMethod))->getReturnType();

        return $returnType instanceof ReflectionNamedType && in_array($returnType->getName(), [TransactionResponse::class, TransactionWith3dsResponse::class, TransactionArrayResponse::class], true);
    }

    private function libraryWith(Response|ConnectException $result): HttpClientLibrary
    {
        $library = new HttpClientLibrary('public_id', 'password');
        $library->replaceClient(new Client([
            'base_uri' => Library::DEFAULT_URL,
            'handler' => HandlerStack::create(new MockHandler([$result])),
        ]));

        return $library;
    }
}
