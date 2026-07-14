<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Enum\Currency;
use Excent\Cloudpayments\Enum\Device;
use Excent\Cloudpayments\Enum\SbpScheme;
use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\CloudpaymentsData;
use Excent\Cloudpayments\Request\SbpLink;
use PHPUnit\Framework\TestCase;

final class SbpLinkTest extends TestCase
{
    public function testAsArraySerializesRequiredFields(): void
    {
        $request = new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE);

        $this->assertSame([
            'Amount' => '1000.00',
            'Currency' => 'RUB',
            'Scheme' => 'charge',
        ], $request->asArray());
    }

    public function testAsArraySerializesOptionalFieldsAndBooleanValues(): void
    {
        $request = new SbpLink(
            '1000.50',
            Currency::RUB,
            SbpScheme::CHARGE,
            'Оплата по СБП',
            'account-id',
            'email@example.com',
            new CloudpaymentsData(additionalData: ['receipt' => []]),
            'order-1',
            'https://example.com/success',
            '127.0.0.1',
            'Android',
            false,
            Device::MOBILE_APP,
            'Chrome',
            129600,
            false,
            false,
        );

        $this->assertSame([
            'Amount' => '1000.50',
            'Currency' => 'RUB',
            'Scheme' => 'charge',
            'Description' => 'Оплата по СБП',
            'AccountId' => 'account-id',
            'Email' => 'email@example.com',
            'JsonData' => '{"cloudpayments":{"receipt":[]}}',
            'InvoiceId' => 'order-1',
            'SuccessRedirectUrl' => 'https://example.com/success',
            'IpAddress' => '127.0.0.1',
            'Os' => 'Android',
            'Webview' => 'false',
            'Device' => 'MobileApp',
            'Browser' => 'Chrome',
            'TtlMinutes' => 129600,
            'SaveCard' => 'false',
            'IsTest' => 'false',
        ], $request->asArray());
    }

    public function testAsArrayExcludesNullOptionalFields(): void
    {
        $request = new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE);

        $this->assertArrayNotHasKey('Description', $request->asArray());
        $this->assertArrayNotHasKey('PublicId', $request->asArray());
        $this->assertCount(3, $request->asArray());
    }

    public function testAsArraySerializesCloudpaymentsDataObject(): void
    {
        $request = new SbpLink(
            '1000.00',
            Currency::RUB,
            SbpScheme::CHARGE,
            jsonData: new CloudpaymentsData(additionalData: ['name' => 'Customer']),
        );

        $this->assertSame(
            '{"cloudpayments":{"name":"Customer"}}',
            $request->asArray()['JsonData']
        );
    }

    /**
     * @dataProvider validTtlMinutesProvider
     */
    public function testAcceptsValidTtlMinutes(int $ttlMinutes): void
    {
        $request = new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE, ttlMinutes: $ttlMinutes);

        $this->assertSame($ttlMinutes, $request->ttlMinutes);
    }

    /**
     * @dataProvider invalidTtlMinutesProvider
     */
    public function testRejectsInvalidTtlMinutes(int $ttlMinutes): void
    {
        $this->expectException(BadTypeException::class);

        new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE, ttlMinutes: $ttlMinutes);
    }

    public function testRejectsAmountWithMoreThanTwoDecimalPlaces(): void
    {
        $this->expectException(BadTypeException::class);

        new SbpLink('1000.123', Currency::RUB, SbpScheme::CHARGE);
    }

    public function testRejectsUnsupportedCurrency(): void
    {
        $this->expectException(BadTypeException::class);

        new SbpLink('1000.00', Currency::USD, SbpScheme::CHARGE);
    }

    public function testRejectsInvalidSuccessRedirectUrl(): void
    {
        $this->expectException(BadTypeException::class);

        new SbpLink('1000.00', Currency::RUB, SbpScheme::CHARGE, successRedirectUrl: 'https://example.com/тест');
    }

    /**
     * @return array<string, array{0: int}>
     */
    public static function validTtlMinutesProvider(): array
    {
        return [
            'minimum' => [1],
            'maximum' => [129600],
        ];
    }

    /**
     * @return array<string, array{0: int}>
     */
    public static function invalidTtlMinutesProvider(): array
    {
        return [
            'zero' => [0],
            'above maximum' => [129601],
        ];
    }
}
