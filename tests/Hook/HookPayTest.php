<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Hook;

use Excent\Cloudpayments\Hook\HookPay;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class HookPayTest extends TestCase
{
    public function testConstructorFillsFieldsFromRequest(): void
    {
        $request = [
            'TransactionId' => 123,
            'Amount' => 10.5,
            'Currency' => 'RUB',
            'DateTime' => '2024-01-01T00:00:00Z',
            'CardFirstSix' => '411111',
            'CardLastFour' => '1111',
            'CardType' => 'Visa',
            'CardExpDate' => '12/30',
            'TestMode' => 1,
            'Status' => 'Completed',
            'OperationType' => 'Payment',
            'GatewayName' => 'Gateway',
        ];

        $hook = new HookPay($request);

        $this->assertSame($request, $hook->getRequest());
        $this->assertSame(123, $hook->transactionId);
        $this->assertSame(10.5, $hook->amount);
        $this->assertSame('Gateway', $hook->gatewayName);
    }
}
