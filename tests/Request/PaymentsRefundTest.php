<?php

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\PaymentsRefund;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentsRefundTest.
 *
 * @group Cloudpayments
 */
class PaymentsRefundTest extends TestCase
{
    /**
     * Проверяем валидацию для amount - успешный вариант
     */
    public function testCheckValidationAmountSuccessInt(): void
    {
        $amount = 1;
        $transactionId = 123;

        $paymentsRefundRequest = new PaymentsRefund($transactionId, $amount);
        $this->assertEquals($amount, $paymentsRefundRequest->amount);
        $this->assertEquals($transactionId, $paymentsRefundRequest->transactionId);
    }

    /**
     * Проверяем валидацию для amount - успешный вариант
     */
    public function testCheckValidationAmountSuccessFloat(): void
    {
        $amount = 1.123;
        $transactionId = 1;

        $paymentsRefundRequest = new PaymentsRefund($transactionId, $amount);
        $this->assertEquals($amount, $paymentsRefundRequest->amount);
        $this->assertEquals($transactionId, $paymentsRefundRequest->transactionId);
    }

    /**
     * Проверяем валидацию для amount - ожидаем ошибку.
     */
    public function testCheckValidationAmountFailed(): void
    {
        $amount = 'asdf';
        $transactionId = 1;

        $this->expectException(BadTypeException::class);
        /* @phan-suppress-next-line PhanNoopNew */
        new PaymentsRefund($transactionId, $amount);
    }
}
