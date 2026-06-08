<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Request\PaymentsList;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class PaymentsListTest extends TestCase
{
    public function testAsArrayContainsDateWithoutTimeZoneWhenTimeZoneIsNotPassed(): void
    {
        $this->assertSame(['Date' => '2024-01-01'], (new PaymentsList('2024-01-01'))->asArray());
    }
}
