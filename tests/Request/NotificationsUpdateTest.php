<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Request\NotificationsUpdate;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class NotificationsUpdateTest extends TestCase
{
    public function testAsArrayCastsIsEnabledToCloudpaymentsBoolean(): void
    {
        $request = new NotificationsUpdate();
        $request->type = 'fail';
        $request->isEnabled = false;

        $this->assertSame([
            'Type' => 'fail',
            'IsEnabled' => 'false',
        ], $request->asArray());
    }
}
