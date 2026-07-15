<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Enum\Currency;
use Excent\Cloudpayments\Enum\Device;
use Excent\Cloudpayments\Enum\SbpScheme;
use Excent\Cloudpayments\Exceptions\BadTypeException;
use JsonException;

/**
 * Запрос на оплату через СБП.
 *
 * @see https://developers.cloudpayments.ru/#sbp-poluchenie-ssylki-dlya-oplaty
 * @see https://developers.cloudpayments.ru/#sbp-poluchenie-qr-koda-dlya-oplaty
 */
final class SbpLink extends BaseRequest
{
    public function __construct(
        public string $amount,
        public Currency $currency,
        public SbpScheme $scheme,
        public ?string $description = null,
        public ?string $accountId = null,
        public ?string $email = null,
        public ?CloudpaymentsData $jsonData = null,
        public ?string $invoiceId = null,
        public ?string $successRedirectUrl = null,
        public ?string $ipAddress = null,
        public ?string $os = null,
        public ?bool $webview = null,
        public ?Device $device = null,
        public ?string $browser = null,
        public ?int $ttlMinutes = null,
        public ?bool $saveCard = null,
        public ?bool $isTest = null,
    ) {
        if (preg_match('/^\d+(?:\.\d{1,2})?$/D', $amount) !== 1) {
            throw new BadTypeException('Amount must be a decimal string with no more than 2 decimal places');
        }

        if ($currency !== Currency::RUB) {
            throw new BadTypeException('Currency must be RUB');
        }

        if ($successRedirectUrl !== null && (
            strlen($successRedirectUrl) > 1024
            || preg_match('/[^\x00-\x7F]/', $successRedirectUrl) === 1
            || filter_var($successRedirectUrl, FILTER_VALIDATE_URL) === false
        )) {
            throw new BadTypeException(
                'SuccessRedirectUrl must be an ASCII RFC 3986 URL no longer than 1024 characters'
            );
        }

        if ($ttlMinutes !== null && ($ttlMinutes < 1 || $ttlMinutes > 129600)) {
            throw new BadTypeException('TtlMinutes must be between 1 and 129600');
        }
    }

    /**
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function asArray(): array
    {
        $data = parent::asArray();

        if ($this->jsonData instanceof CloudpaymentsData) {
            $data['JsonData'] = $this->jsonData->asJson();
        }

        if ($this->device !== null) {
            $data['Device'] = $this->device->value;
        }

        $data['Currency'] = $this->currency->value;
        $data['Scheme'] = $this->scheme->value;

        return $data;
    }
}
