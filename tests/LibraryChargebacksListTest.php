<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use DateTimeImmutable;
use Excent\Cloudpayments\Request\ChargebacksList;
use Excent\Cloudpayments\Response\ChargebackArrayResponse;
use Excent\Cloudpayments\Response\Models\ChargebackModel;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class LibraryChargebacksListTest extends TestCase
{
    public function testSendsExactRequestThroughLibraryFlow(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse(new Response(200, [], <<<'JSON'
            {
                "Success": true,
                "Model": [{
                    "ChargeBackId": "6811d4a17bab1c4b44c19371",
                    "TerminalUrl": "https://cloudpayments.ru/",
                    "TransactionId": 2200203594,
                    "Amount": 100,
                    "Currency": "RUB",
                    "Type": "Chargeback",
                    "Operation": "Presentment",
                    "Card": "520500*******3055",
                    "Gateway": "SberbankRu",
                    "Date": "/Date(1745960400000)/"
                }]
            }
            JSON));

        $request = new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
        );
        $requestBeforeCall = $request->asArray();

        $result = $library->chargebacksList($request);

        $this->assertInstanceOf(ChargebackArrayResponse::class, $result);
        $this->assertSame('chargebacks/list', $library->lastMethod);
        $this->assertSame([
            'CreatedDateGte' => '2021-03-09T00:00:00+03:00',
            'CreatedDateLte' => '2021-03-10T00:00:00+03:00',
            'PageNumber' => 1,
        ], $library->lastPostData);
        $this->assertSame($requestBeforeCall, $request->asArray());
        $this->assertCount(1, $result->model);
        $this->assertInstanceOf(ChargebackModel::class, $result->model[0]);
        $this->assertSame('6811d4a17bab1c4b44c19371', $result->model[0]->chargeBackId);
    }
}
