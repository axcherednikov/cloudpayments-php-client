<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class PaymentsGet.
 *
 * @see     https://developers.cloudpayments.ru/#prosmotr-tranzaktsii
 */
class PaymentsGet extends BaseRequest
{
    public function __construct(public int $transactionId)
    {
    }
}
