<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\Models\TransactionWith3dsModel;
use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class TransactionWith3dsModelTest extends TestCase
{
    public function testFalse3dsChallengeAndDeclineResponsesHydrateTransactionId(): void
    {
        foreach ([
            ['{"Success":false,"Model":{"TransactionId":9007199254740993,"PaReq":"request","AcsUrl":"https://acs.example"}}', 9007199254740993, true],
            ['{"Success":false,"Model":{"TransactionId":"00042","Reason":"declined"}}', 42, false],
        ] as [$json, $expectedId, $is3dsError]) {
            $response = new TransactionWith3dsResponse();
            $response->fillByResponse(new Response(200, [], $json));

            $this->assertFalse($response->success);
            $this->assertInstanceOf(TransactionWith3dsModel::class, $response->model);
            $this->assertSame($expectedId, $response->model->transactionId);
            $this->assertSame($is3dsError, $response->is3dsError());
        }
    }

    public function testIs3dsErrorReturnsFalseWithoutModel(): void
    {
        $response = new TransactionWith3dsResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":false,"Message":"not found"}'));

        $this->assertFalse($response->is3dsError());
    }

    public function testIs3dsErrorReturnsTrueWhenPaReqAndAcsUrlAreFilled(): void
    {
        $responseModel = (object) ['TransactionId' => 1, 'PaReq' => 'some', 'AcsUrl' => 'some'];

        $cloudResponseModel = new TransactionWith3dsResponse();
        $cloudResponseModel->fillModel($responseModel);

        $this->assertTrue($cloudResponseModel->is3dsError());
    }

    public function testIs3dsErrorReturnsFalseWhenPaReqAndAcsUrlAreMissing(): void
    {
        $responseModel = (object) ['TransactionId' => 1];

        $cloudResponseModel = new TransactionWith3dsResponse();
        $cloudResponseModel->fillModel($responseModel);

        $this->assertFalse($cloudResponseModel->is3dsError());
    }
}
