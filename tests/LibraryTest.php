<?php

namespace Excent\Cloudpayments\Tests;

use Excent\Cloudpayments\Library;
use Excent\Cloudpayments\Request\ApplepayStartSession;
use Excent\Cloudpayments\Request\CardsPayment;
use Excent\Cloudpayments\Request\NotificationsGet;
use Excent\Cloudpayments\Request\OrderCreate;
use Excent\Cloudpayments\Request\PaymentsGet;
use Excent\Cloudpayments\Request\SubscriptionCreate;
use Excent\Cloudpayments\Request\SubscriptionFind;
use Excent\Cloudpayments\Request\TokenPayment;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class LibraryTest.
 *
 * @group Cloudpayments
 */
class LibraryTest extends TestCase
{
    protected $library;

    public function setUp(): void
    {
        parent::setUp();

        $this->library = $this->getMockBuilder(Library::class)
            ->setConstructorArgs(['public_id', 'password'])
            ->onlyMethods(['sendRequest'])
            ->getMock();
    }

    /**
     * Проверяем заполнение модели по запросу
     * createPaymentByToken2Step.
     */
    public function testCreatePaymentByToken2Step(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => false,
            'Message' => null,
            'Model' => ['TransactionId' => 504],
        ]));

        $library = clone $this->library;
        $library
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn($response);

        $result = $library->createPaymentByToken2Step(new TokenPayment(100, 'RUB', '100', '100'));

        $this->assertEquals(false, $result->success);
        $this->assertEquals(504, $result->model->transactionId);
    }

    /**
     * Проверяем заполнение модели по запросу
     * getPaymentData.
     */
    public function testGetPaymentData(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['TransactionId' => 504, 'Amount' => 10.00000],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->getPaymentData(new PaymentsGet(1));

        $this->assertEquals(true, $result->success);
        $this->assertEquals(504, $result->model->transactionId);
        $this->assertEquals(10.0, $result->model->amount);
    }

    /**
     * Проверяем заполнение модели по запросу
     * paymentsCardsCharge.
     */
    public function testPaymentsCardsCharge(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['TransactionId' => 521],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->paymentsCardsCharge(new CardsPayment(1, 'RUB', '0.0.0.0', '123'));

        $this->assertEquals(true, $result->success);
        $this->assertEquals(521, $result->model->transactionId);
    }

    /**
     * Проверяем заполнение модели по запросу
     * paymentsTokensList.
     */
    public function testPaymentsTokensList(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [['Token' => '123asdf']],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->paymentsTokensList();

        $model = $result->model[0];

        $this->assertEquals(true, $result->success);
        $this->assertEquals('123asdf', $model->token);
    }

    /**
     * Проверяем заполнение модели по запросу
     * subscriptionsCreate.
     */
    public function testSubscriptionsCreate(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['Id' => 'sc_8cf8a9338fb8ebf7202b08d09c938'],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->subscriptionsCreate(new SubscriptionCreate());

        $this->assertEquals(true, $result->success);
        $this->assertEquals('sc_8cf8a9338fb8ebf7202b08d09c938', $result->model->id);
    }

    /**
     * Проверяем заполнение модели по запросу
     * subscriptionsFind.
     */
    public function testSubscriptionsFind(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [['Id' => 'sc_b4bdedba0e2bdf279be2e0bab9c99']],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->subscriptionsFind(new SubscriptionFind());

        $model = $result->model[0];

        $this->assertEquals(true, $result->success);
        $this->assertEquals('sc_b4bdedba0e2bdf279be2e0bab9c99', $model->id);
    }

    /**
     * Проверяем заполнение модели по запросу
     * ordersCreate.
     */
    public function testOrdersCreate(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['Id' => 'f2K8LV6reGE9WBFn'],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->ordersCreate(new OrderCreate(1, 'RUB', 'asdf'));

        $this->assertEquals(true, $result->success);
        $this->assertEquals('f2K8LV6reGE9WBFn', $result->model->id);
    }

    /**
     * Проверяем заполнение модели по запросу
     * siteNotificationsGet.
     */
    public function testSiteNotificationsGet(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['Address' => 'http://example.com'],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $notificationModel = new NotificationsGet();
        $notificationModel->type = 'type';
        $result = $library->siteNotificationsGet($notificationModel);

        $this->assertEquals(true, $result->success);
        $this->assertEquals('http://example.com', $result->model->address);
    }

    /**
     * Проверяем заполнение модели по запросу
     * startSession.
     */
    public function testStartSession(): void
    {
        $response = new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['nonce' => 'd6358e06'],
        ]));

        $library = clone $this->library;
        $library->expects($this->once())->method('sendRequest')->willReturn($response);

        $result = $library->startSession(new ApplepayStartSession('https://apple-pay-gateway.apple.com/paymentservices/startSession'));

        $this->assertEquals(true, $result->success);
        $this->assertEquals('d6358e06', $result->model->nonce);
    }
}
