<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\PaymentsConfirm;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class PaymentsConfirmTest extends TestCase
{
    public function testAsArrayContainsNumericAmountAndJsonData(): void
    {
        $request = new PaymentsConfirm('10.50', 123, '{"key":"value"}');

        $this->assertSame([
            'Amount' => '10.50',
            'JsonData' => '{"key":"value"}',
            'TransactionId' => 123,
        ], $request->asArray());
    }

    public function testConstructorRejectsNonNumericAmount(): void
    {
        $this->expectException(BadTypeException::class);

        new PaymentsConfirm('wrong', 123);
    }
}
