<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class PaymentsGet.
 *
 * @see     https://developers.cloudpayments.ru/#prosmotr-tranzaktsii
 */
class PaymentsGet extends BaseRequest
{
    public int $transactionId;

    /**
     * PaymentsGet constructor.
     *
     * @param  int  $transactionId
     */
    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
