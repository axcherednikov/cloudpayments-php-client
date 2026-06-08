<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\PaymentsRefund;
use PHPUnit\Framework\TestCase;

final class PaymentsRefundTest extends TestCase
{
    public function testConstructorAcceptsIntegerAmount(): void
    {
        $amount = 1;
        $transactionId = 123;

        $paymentsRefundRequest = new PaymentsRefund($transactionId, $amount);
        $this->assertEquals($amount, $paymentsRefundRequest->amount);
        $this->assertEquals($transactionId, $paymentsRefundRequest->transactionId);
    }

    public function testConstructorAcceptsFloatAmount(): void
    {
        $amount = 1.123;
        $transactionId = 1;

        $paymentsRefundRequest = new PaymentsRefund($transactionId, $amount);
        $this->assertEquals($amount, $paymentsRefundRequest->amount);
        $this->assertEquals($transactionId, $paymentsRefundRequest->transactionId);
    }

    public function testConstructorRejectsNonNumericAmount(): void
    {
        $amount = 'asdf';
        $transactionId = 1;

        $this->expectException(BadTypeException::class);
        new PaymentsRefund($transactionId, $amount);
    }
}
