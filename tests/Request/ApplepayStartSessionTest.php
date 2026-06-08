<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\ApplepayStartSession;
use PHPUnit\Framework\TestCase;

final class ApplepayStartSessionTest extends TestCase
{
    public function testConstructorAcceptsValidValidationUrl(): void
    {
        $validationUrl = 'https://apple-pay-gateway.apple.com/paymentservices/startSession';

        $appleStartSessionRequest = new ApplepayStartSession($validationUrl);
        $this->assertEquals($validationUrl, $appleStartSessionRequest->validationUrl);
    }

    public function testConstructorRejectsInvalidValidationUrl(): void
    {
        $validationUrl = 'asdf';

        $this->expectException(BadTypeException::class);
        new ApplepayStartSession($validationUrl);
    }

    public function testConstructorAcceptsValidPaymentUrl(): void
    {
        $validationUrl = 'https://apple-pay-gateway.apple.com/paymentservices/startSession';
        $paymentUrl = 'https://apple-pay-gateway.apple.com/paymentservices/startSession';

        $appleStartSessionRequest = new ApplepayStartSession($validationUrl, $paymentUrl);

        $this->assertEquals($validationUrl, $appleStartSessionRequest->validationUrl);
        $this->assertEquals($paymentUrl, $appleStartSessionRequest->paymentUrl);
    }

    public function testConstructorLeavesPaymentUrlUnsetWhenItIsNotPassed(): void
    {
        $validationUrl = 'https://apple-pay-gateway.apple.com/paymentservices/startSession';

        $appleStartSessionRequest = new ApplepayStartSession($validationUrl);

        $vars = get_object_vars($appleStartSessionRequest);
        $this->assertFalse(isset($vars['paymentUrl']));
    }

    public function testConstructorRejectsInvalidPaymentUrl(): void
    {
        $validationUrl = 'https://apple-pay-gateway.apple.com/paymentservices/startSession';
        $paymentUrl = 'asdf';

        $this->expectException(BadTypeException::class);
        new ApplepayStartSession($validationUrl, $paymentUrl);
    }
}
