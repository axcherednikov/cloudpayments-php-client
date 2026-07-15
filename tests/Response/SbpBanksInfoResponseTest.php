<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\Models\SbpBankMemberModel;
use Excent\Cloudpayments\Response\Models\SbpBanksInfoModel;
use Excent\Cloudpayments\Response\SbpBanksInfoResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SbpBanksInfoResponseTest extends TestCase
{
    public function testFillByResponseCreatesTypedModelsAndPreservesValuesAndOrder(): void
    {
        $response = new SbpBanksInfoResponse();
        $response->fillByResponse(new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => 'ok',
            'Model' => [
                [
                    'Source' => 'widget',
                    'Version' => '2.0',
                    'FutureField' => 'source-extra',
                    'members' => [
                        [
                            'id' => '100000000111',
                            'logo' => 'https://qr.nspk.ru/proxyapp/logo/bank100000000111.png',
                            'name' => 'Сбербанк',
                            'url' => 'bank100000000111://qr.nspk.ru/{QRC_ID}{QUERY_STRING}',
                            'FutureMemberField' => 'member-extra',
                        ],
                        [
                            'id' => '100000000222',
                            'logo' => 'https://example.test/logo-2.png',
                            'name' => 'Второй банк',
                            'url' => 'bank100000000222://qr.nspk.ru/{QRC_ID}{QUERY_STRING}',
                        ],
                    ],
                ],
                [
                    'source' => 'mobile',
                    'version' => '1.0',
                    'Members' => [],
                ],
            ],
        ], JSON_THROW_ON_ERROR)));

        $this->assertTrue($response->success);
        $this->assertSame('ok', $response->message);
        $this->assertCount(2, $response->model);
        $this->assertInstanceOf(SbpBanksInfoModel::class, $response->model[0]);
        $this->assertSame('widget', $response->model[0]->source);
        $this->assertSame('2.0', $response->model[0]->version);
        $this->assertSame('source-extra', $response->model[0]->getAdditionalProperties()['futureField']);

        $this->assertCount(2, $response->model[0]->members);
        $this->assertInstanceOf(SbpBankMemberModel::class, $response->model[0]->members[0]);
        $this->assertSame('100000000111', $response->model[0]->members[0]->id);
        $this->assertSame('Сбербанк', $response->model[0]->members[0]->name);
        $this->assertSame(
            'https://qr.nspk.ru/proxyapp/logo/bank100000000111.png',
            $response->model[0]->members[0]->logo
        );
        $this->assertSame(
            'bank100000000111://qr.nspk.ru/{QRC_ID}{QUERY_STRING}',
            $response->model[0]->members[0]->url
        );
        $this->assertSame(
            'member-extra',
            $response->model[0]->members[0]->getAdditionalProperties()['futureMemberField']
        );

        $this->assertSame('mobile', $response->model[1]->source);
        $this->assertSame('1.0', $response->model[1]->version);
        $this->assertSame([], $response->model[1]->members);
    }

    public function testMissingOrEmptyModelLeavesEmptyArray(): void
    {
        $emptyModelResponse = new SbpBanksInfoResponse();
        $emptyModelResponse->fillByResponse(new Response(200, [], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [],
        ], JSON_THROW_ON_ERROR)));

        $missingModelResponse = new SbpBanksInfoResponse();
        $missingModelResponse->fillByResponse(new Response(200, [], json_encode([
            'Success' => true,
            'Message' => null,
        ], JSON_THROW_ON_ERROR)));

        $this->assertSame([], $emptyModelResponse->model);
        $this->assertSame([], $missingModelResponse->model);
    }
}
