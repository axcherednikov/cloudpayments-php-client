<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Request\PaymentsFind;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class PaymentsFindTest extends TestCase
{
    public function testAsArrayContainsInvoiceId(): void
    {
        $this->assertSame(['InvoiceId' => 'invoice'], (new PaymentsFind('invoice'))->asArray());
    }
}
