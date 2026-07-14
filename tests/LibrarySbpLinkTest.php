<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests;

use Excent\Cloudpayments\Enum\Currency;
use Excent\Cloudpayments\Enum\SbpScheme;
use Excent\Cloudpayments\Request\SbpLink;
use Excent\Cloudpayments\Response\QrLinkResponse;
use Excent\Cloudpayments\Tests\Support\RecordingLibrary;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class LibrarySbpLinkTest extends TestCase
{
    public function testPaymentsQrSbpLinkSendsPublicIdAndReturnsTypedResponse(): void
    {
        $library = new RecordingLibrary('public_id', 'password');
        $library->setNextResponse(new Response(200, ['Content-type' => 'application/json'], json_encode([
            'Success' => true,
            'Message' => null,
            'Model' => ['QrUrl' => 'https://qr.nspk.ru/example'],
        ], JSON_THROW_ON_ERROR)));

        $request = new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE);
        $result = $library->paymentsQrSbpLink($request);

        $this->assertInstanceOf(QrLinkResponse::class, $result);
        $this->assertTrue($result->success);
        $this->assertSame('payments/qr/sbp/link', $library->lastMethod);
        $this->assertSame([
            'Amount' => '1000.00',
            'Currency' => 'RUB',
            'Scheme' => 'charge',
            'PublicId' => 'public_id',
        ], $library->lastPostData);
        $this->assertArrayNotHasKey('PublicId', $request->asArray());
    }
}
