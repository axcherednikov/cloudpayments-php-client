<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use Excent\Cloudpayments\Request\PaymentsFind;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use Excent\Cloudpayments\Response\TransactionResponse;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class LibraryPaymentsFindV2Test extends TestCase
{
    public function testFindsLatestOperationByInvoiceIncludingRefundsAndCardPayouts(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse(new Response(
            200,
            [],
            '{"Success":true,"Message":null,"Model":{"TransactionId":504,"InvoiceId":"invoice-1","Amount":100.0,"Status":"Completed"}}'
        ));

        $result = $library->getPaymentDataByInvoiceV2(new PaymentsFind('invoice-1'));

        $this->assertInstanceOf(TransactionResponse::class, $result);
        $this->assertSame('v2/payments/find', $library->lastMethod);
        $this->assertSame(['InvoiceId' => 'invoice-1'], $library->lastPostData);
        $this->assertTrue($result->success);
        $this->assertInstanceOf(TransactionModel::class, $result->model);
        $this->assertSame(504, $result->model->transactionId);
        $this->assertSame('invoice-1', $result->model->invoiceId);
        $this->assertSame(100.0, $result->model->amount);
        $this->assertSame('Completed', $result->model->status);
    }

    public function testReturnsFailureWhenOperationIsNotFound(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse(new Response(200, [], '{"Success":false,"Message":"Not found"}'));

        $result = $library->getPaymentDataByInvoiceV2(new PaymentsFind('invoice-1'));

        $this->assertInstanceOf(TransactionResponse::class, $result);
        $this->assertFalse($result->success);
        $this->assertSame('Not found', $result->message);
        $this->assertSame('v2/payments/find', $library->lastMethod);
        $this->assertSame(['InvoiceId' => 'invoice-1'], $library->lastPostData);
    }
}
