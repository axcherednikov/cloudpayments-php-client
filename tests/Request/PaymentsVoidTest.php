<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Request\PaymentsVoid;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class PaymentsVoidTest extends TestCase
{
    public function testAsArrayContainsTransactionId(): void
    {
        $this->assertSame(['TransactionId' => 123], (new PaymentsVoid(123))->asArray());
    }
}
