<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class PaymentsFind.
 *
 * @see     https://developers.cloudpayments.ru/#proverka-statusa-platezha
 */
class PaymentsFind extends BaseRequest
{
    public string $invoiceId;

    /**
     * PaymentsFind constructor.
     *
     * @param  string  $invoiceId
     */
    public function __construct(string $invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }
}
