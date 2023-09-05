<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class PaymentsFind.
 *
 * @see     https://developers.cloudpayments.ru/#proverka-statusa-platezha
 */
class PaymentsFind extends BaseRequest
{
    /**
     * PaymentsFind constructor.
     */
    public function __construct(public string $invoiceId)
    {
    }
}
