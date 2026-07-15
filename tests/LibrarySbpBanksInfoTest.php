<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use Excent\Cloudpayments\Enum\SbpPlatform;
use Excent\Cloudpayments\Request\SbpBanksInfo;
use Excent\Cloudpayments\Response\SbpBanksInfoResponse;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class LibrarySbpBanksInfoTest extends TestCase
{
    public function testSbpV2BanksInfoWithoutRequestSendsOnlyPublicTerminalId(): void
    {
        $library = $this->createLibrary();

        $this->assertInstanceOf(SbpBanksInfoResponse::class, $library->sbpV2BanksInfo());
        $this->assertSame('sbp/v2/banks/info', $library->lastMethod);
        $this->assertSame([
            'PublicTerminalId' => 'public_id',
        ], $library->lastPostData);
    }

    public function testSbpV2BanksInfoAddsPublicTerminalIdWithoutMutatingRequest(): void
    {
        $library = $this->createLibrary();
        $request = new SbpBanksInfo(
            accountId: 'account-id',
            platform: SbpPlatform::ANDROID,
            saveCard: true,
        );
        $requestDataBeforeCall = $request->asArray();

        $this->assertInstanceOf(SbpBanksInfoResponse::class, $library->sbpV2BanksInfo($request));
        $this->assertSame('sbp/v2/banks/info', $library->lastMethod);
        $this->assertSame([
            'AccountId' => 'account-id',
            'Platform' => 'android',
            'SaveCard' => 'true',
            'PublicTerminalId' => 'public_id',
        ], $library->lastPostData);
        $this->assertSame($requestDataBeforeCall, $request->asArray());
        $this->assertArrayNotHasKey('PublicTerminalId', $request->asArray());
    }

    private function createLibrary(): RecordingLibrary
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse(new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => [],
        ], JSON_THROW_ON_ERROR)));

        return $library;
    }
}
