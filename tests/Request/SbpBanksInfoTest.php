<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Enum\SbpPlatform;
use Excent\Cloudpayments\Request\SbpBanksInfo;
use PHPUnit\Framework\TestCase;

final class SbpBanksInfoTest extends TestCase
{
    public function testEmptyRequestSerializesToEmptyArray(): void
    {
        $request = new SbpBanksInfo();

        $this->assertSame([], $request->asArray());
    }

    public function testAsArraySerializesAllFieldsWithApiNames(): void
    {
        $request = new SbpBanksInfo(
            accountId: 'account-id',
            isRenewSubscription: true,
            jsonData: '{"customer":"John"}',
            platform: SbpPlatform::IOS,
            saveCard: false,
            token: 'token-value',
        );

        $this->assertSame([
            'AccountId' => 'account-id',
            'IsRenewSubscription' => 'true',
            'JsonData' => '{"customer":"John"}',
            'Platform' => 'ios',
            'SaveCard' => 'false',
            'Token' => 'token-value',
        ], $request->asArray());
    }

    public function testAsArrayExcludesNullFields(): void
    {
        $request = new SbpBanksInfo(accountId: 'account-id', platform: SbpPlatform::DESKTOP);

        $this->assertSame([
            'AccountId' => 'account-id',
            'Platform' => 'desktop',
        ], $request->asArray());
        $this->assertArrayNotHasKey('IsRenewSubscription', $request->asArray());
        $this->assertArrayNotHasKey('JsonData', $request->asArray());
        $this->assertArrayNotHasKey('SaveCard', $request->asArray());
        $this->assertArrayNotHasKey('Token', $request->asArray());
    }
}
