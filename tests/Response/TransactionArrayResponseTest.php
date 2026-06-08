<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\TransactionArrayResponse;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class TransactionArrayResponseTest extends TestCase
{
    public function testFillModelCreatesTransactionModels(): void
    {
        $response = new TransactionArrayResponse();
        $response->fillModel([
            (object) ['TransactionId' => 123],
            (object) ['TransactionId' => 456],
        ]);

        $this->assertCount(2, $response->model);
        $this->assertSame(123, $response->model[0]->transactionId);
        $this->assertSame(456, $response->model[1]->transactionId);
    }
}
