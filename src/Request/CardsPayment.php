<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

/**
 * @see     https://developers.cloudpayments.ru/#oplata-po-kriptogramme
 */
class CardsPayment extends BaseRequest
{
    public function __construct(
        public float|int $amount,
        public string $currency,
        public string $ipAddress,
        public string $cardCryptogramPacket,
        //Обязательно если не эппл и не гуглпей
        public ?string $name = null,
        public ?string $paymentUrl = null,
        public ?string $invoiceId = null,
        public ?string $description = null,
        public ?string $cultureName = null,
        public ?string $accountId = null,
        public ?string $email = null,
        public ?array $payer = null,
        public ?string $jsonData = null
    ) {
    }
}
