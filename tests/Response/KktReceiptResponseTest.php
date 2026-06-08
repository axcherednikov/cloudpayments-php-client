<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\KktReceiptResponse;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class KktReceiptResponseTest extends TestCase
{
    public function testFillModelCreatesKktReceiptModel(): void
    {
        $response = new KktReceiptResponse();
        $response->fillModel((object) ['Id' => 'receipt-id', 'ErrorCode' => 0]);

        $this->assertSame('receipt-id', $response->model->id);
        $this->assertSame(0, $response->model->errorCode);
    }
}
