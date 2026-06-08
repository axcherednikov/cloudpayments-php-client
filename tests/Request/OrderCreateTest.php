<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\OrderCreate;
use PHPUnit\Framework\TestCase;

final class OrderCreateTest extends TestCase
{
    public function testConstructorAcceptsIntegerAmount(): void
    {
        $amount = 1;
        $currency = 'RUB';
        $description = 'asdf';

        $orderCreateRequest = new OrderCreate($amount, $currency, $description);
        $this->assertEquals($amount, $orderCreateRequest->amount);
        $this->assertEquals($currency, $orderCreateRequest->currency);
        $this->assertEquals($description, $orderCreateRequest->description);
    }

    public function testConstructorAcceptsFloatAmount(): void
    {
        $amount = 1.123;
        $currency = 'RUB';
        $description = 'asdf';

        $orderCreateRequest = new OrderCreate($amount, $currency, $description);
        $this->assertEquals($amount, $orderCreateRequest->amount);
        $this->assertEquals($currency, $orderCreateRequest->currency);
        $this->assertEquals($description, $orderCreateRequest->description);
    }

    public function testConstructorRejectsNonNumericAmount(): void
    {
        $amount = 'asdf';
        $currency = 'RUB';
        $description = 'asdf';

        $this->expectException(BadTypeException::class);
        new OrderCreate($amount, $currency, $description);
    }

    public function testAsArrayCastsRequireConfirmationToCloudpaymentsBoolean(): void
    {
        $order = new OrderCreate(10, 'RUB', 'description');
        $order->requireConfirmation = true;

        $this->assertSame('true', $order->asArray()['RequireConfirmation']);
    }
}
