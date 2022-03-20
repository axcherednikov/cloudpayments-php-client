<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class TokenPayment
 *
 * @package Excent\Cloudpayments\CardPayment
 * @see     https://developers.cloudpayments.ru/#oplata-po-tokenu-rekarring
 */
class TokenPayment extends BaseRequest
{
    public function __construct(
        public int|float $amount,
        public string $currency,
        public string $accountId,
        public string $token,
        public ?string $invoiceId = null,
        public ?string $description = null,
        public ?string $ipAddress = null,
        public ?string $email = null,
        public ?string $jsonData = null,
    ) {
    }
}
