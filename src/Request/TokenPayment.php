<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class TokenPayment.
 *
 * @see     https://developers.cloudpayments.ru/#oplata-po-tokenu-rekarring
 */
class TokenPayment extends BaseRequest
{
    public function __construct(
        public int|float $amount,
        public string $currency,
        public string|int $accountId,
        public string|int $token,
        public null|string|int $invoiceId = null,
        public ?string $description = null,
        public ?string $ipAddress = null,
        public ?string $email = null,
        public ?string $jsonData = null,
        public int $paymentScheduled = 0,
        public int $trInitiatorCode = 1,
    ) {
    }
}
