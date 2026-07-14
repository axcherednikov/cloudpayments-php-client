<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\Models\QrLinkModel;
use Excent\Cloudpayments\Response\QrLinkResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class QrLinkResponseTest extends TestCase
{
    public function testFillByResponseCreatesTypedModelAndPreservesUnknownFields(): void
    {
        $response = new QrLinkResponse();
        $response->fillByResponse(new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => 'ok',
            'Model' => [
                'QrUrl' => 'https://qr.nspk.ru/example',
                'QrImage' => null,
                'TransactionId' => 11122233344,
                'MerchantOrderId' => 'order-1',
                'ProviderQrId' => 'provider-qr-id',
                'Amount' => 1000.50,
                'Message' => 'Created',
                'IsTest' => false,
                'FutureField' => 'preserved',
            ],
        ], JSON_THROW_ON_ERROR)));

        $this->assertTrue($response->success);
        $this->assertSame('ok', $response->message);
        $this->assertInstanceOf(QrLinkModel::class, $response->model);
        $this->assertSame('https://qr.nspk.ru/example', $response->model->qrUrl);
        $this->assertNull($response->model->qrImage);
        $this->assertSame(11122233344, $response->model->transactionId);
        $this->assertSame('order-1', $response->model->merchantOrderId);
        $this->assertSame('provider-qr-id', $response->model->providerQrId);
        $this->assertSame(1000.50, $response->model->amount);
        $this->assertSame('Created', $response->model->message);
        $this->assertFalse($response->model->isTest);
        $this->assertSame('preserved', $response->model->getAdditionalProperties()['futureField']);
    }
}
