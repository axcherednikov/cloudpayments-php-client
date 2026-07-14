<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * Сведения о безналичной оплате, тег ОФД 1234.
 *
 * @see https://developers.cloudkassir.ru/#noncashpayments
 */
final class NonCashPayments extends BaseRequest
{
    public function __construct(
        public int|float $amount,
        public int $paymentMethod,
        public string $paymentId,
        public ?string $additionalInfo = null,
    ) {
    }
}
