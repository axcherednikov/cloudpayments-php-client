<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\ChargebackArrayResponse;
use Excent\Cloudpayments\Response\Models\ChargebackModel;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ChargebackArrayResponseTest extends TestCase
{
    public function testFillByResponseCreatesModelsAndPreservesOrder(): void
    {
        $response = new ChargebackArrayResponse();
        $response->fillByResponse(new Response(200, [], <<<'JSON'
            {
                "Success": true,
                "Message": "Loaded",
                "ErrorCode": 17,
                "Model": [
                    {
                        "ChargeBackId": "first",
                        "TerminalUrl": "https://first.example/",
                        "TransactionId": 2200203594,
                        "Amount": 100,
                        "Currency": "RUB",
                        "Type": "Chargeback",
                        "Operation": "Presentment",
                        "Card": "520500*******3055",
                        "Gateway": "SberbankRu",
                        "Date": "/Date(1745960400000)/",
                        "FutureField": "available"
                    },
                    {
                        "ChargeBackId": "second",
                        "TerminalUrl": "https://second.example/",
                        "TransactionId": 2200203595,
                        "Amount": 12.5,
                        "Currency": "USD",
                        "Type": "Fee",
                        "Operation": "Representment",
                        "Card": "424242*******4242",
                        "Gateway": "AnotherBank",
                        "Date": "/Date(1745960500000)/"
                    }
                ]
            }
            JSON));

        $this->assertTrue($response->success);
        $this->assertSame('Loaded', $response->message);
        $this->assertSame(17, $response->errorCode);
        $this->assertCount(2, $response->model);
        $this->assertContainsOnlyInstancesOf(ChargebackModel::class, $response->model);

        $first = $response->model[0];
        $this->assertSame('first', $first->chargeBackId);
        $this->assertSame('https://first.example/', $first->terminalUrl);
        $this->assertSame(2200203594, $first->transactionId);
        $this->assertSame(100, $first->amount);
        $this->assertSame('RUB', $first->currency);
        $this->assertSame('Chargeback', $first->type);
        $this->assertSame('Presentment', $first->operation);
        $this->assertSame('520500*******3055', $first->card);
        $this->assertSame('SberbankRu', $first->gateway);
        $this->assertSame('/Date(1745960400000)/', $first->date);
        $this->assertSame('available', $first->getAdditionalProperties()['futureField']);

        $second = $response->model[1];
        $this->assertSame('second', $second->chargeBackId);
        $this->assertSame(12.5, $second->amount);
        $this->assertSame('Fee', $second->type);
        $this->assertSame('Representment', $second->operation);
        $this->assertSame('/Date(1745960500000)/', $second->date);
    }

    public function testNullErrorCodeRemainsNull(): void
    {
        $response = new ChargebackArrayResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":true,"ErrorCode":null,"Model":[]}'));

        $this->assertNull($response->errorCode);
        $this->assertSame([], $response->model);
    }

    public function testMissingModelLeavesEmptyList(): void
    {
        $response = new ChargebackArrayResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":true}'));

        $this->assertSame([], $response->model);
    }

    public function testFillModelSkipsInvalidElementsAndNonArrayInput(): void
    {
        $response = new ChargebackArrayResponse();
        $response->fillModel([
            'invalid',
            (object) [
                'ChargeBackId' => 'valid',
                'TerminalUrl' => 'https://example.com/',
                'TransactionId' => 1,
                'Amount' => 1,
                'Currency' => 'RUB',
                'Type' => 'Chargeback',
                'Operation' => 'Presentment',
                'Card' => '4242********4242',
                'Gateway' => 'Bank',
                'Date' => '/Date(1)/',
            ],
            [],
        ]);

        $this->assertCount(1, $response->model);
        $this->assertInstanceOf(ChargebackModel::class, $response->model[0]);

        $response->fillModel(new stdClass());

        $this->assertSame([], $response->model);
    }
}
