<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#amounts
 */
class ReceiptAmounts extends BaseRequest
{
    public ?string $electronic = null;
    public ?string $advancePayment = null;
    public ?string $credit = null;
    public ?string $provision = null;
}
