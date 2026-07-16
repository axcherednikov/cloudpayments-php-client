<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use DateTimeImmutable;
use Excent\Cloudpayments\Enum\TimezoneCodes;
use Excent\Cloudpayments\Enum\TransactionStatus;
use Excent\Cloudpayments\Request\PaymentsListV2;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use Excent\Cloudpayments\Response\TransactionArrayResponse;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\TestCase;

final class LibraryPaymentsListV2Test extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testSendsRequestAndPreservesTransactionOrder(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse($this->jsonResponse(json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [
                [
                    'TransactionId' => 2,
                    'CreatedDateIso' => '2021-03-09T01:00:00+03:00',
                    'Status' => 'Completed',
                ],
                [
                    'TransactionId' => 1,
                    'CreatedDateIso' => '2021-03-09T00:00:00+03:00',
                    'Status' => 'Authorized',
                ],
            ],
        ], JSON_THROW_ON_ERROR)));

        $request = new PaymentsListV2(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
            TimezoneCodes::MSK,
            [TransactionStatus::AUTHORIZED, TransactionStatus::COMPLETED],
        );

        $result = $library->getListPaymentV2($request);

        $this->assertInstanceOf(TransactionArrayResponse::class, $result);
        $this->assertTrue($result->success);
        $this->assertSame('v2/payments/list', $library->lastMethod);
        $this->assertSame([
            'CreatedDateGte' => '2021-03-09T00:00:00+03:00',
            'CreatedDateLte' => '2021-03-10T00:00:00+03:00',
            'PageNumber' => 1,
            'TimeZone' => 'MSK',
            'Statuses' => ['Authorized', 'Completed'],
        ], $library->lastPostData);

        $this->assertCount(2, $result->model);
        $this->assertInstanceOf(TransactionModel::class, $result->model[0]);
        $this->assertInstanceOf(TransactionModel::class, $result->model[1]);
        $this->assertSame(2, $result->model[0]->transactionId);
        $this->assertSame('2021-03-09T01:00:00+03:00', $result->model[0]->createdDateIso);
        $this->assertSame('Completed', $result->model[0]->status);
        $this->assertSame(1, $result->model[1]->transactionId);
        $this->assertSame('2021-03-09T00:00:00+03:00', $result->model[1]->createdDateIso);
        $this->assertSame('Authorized', $result->model[1]->status);
    }

    /**
     * @throws JsonException
     */
    public function testEmptyModelIsInitializedAsEmptyArray(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse($this->jsonResponse(json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [],
        ], JSON_THROW_ON_ERROR)));

        $result = $library->getListPaymentV2($this->request());

        $this->assertTrue($result->success);
        $this->assertSame([], $result->model);
    }

    /**
     * @throws JsonException
     */
    public function testMissingModelLeavesModelAsEmptyArray(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse($this->jsonResponse(json_encode(['Success' => true], JSON_THROW_ON_ERROR)));

        $result = $library->getListPaymentV2($this->request());

        $this->assertTrue($result->success);
        $this->assertSame([], $result->model);
    }

    private function request(): PaymentsListV2
    {
        return new PaymentsListV2(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
        );
    }

    private function jsonResponse(string $payload): Response
    {
        return new Response(200, ['Content-type' => 'application/json'], $payload);
    }
}
