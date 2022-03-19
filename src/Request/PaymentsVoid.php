<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class PaymentsVoid
 *
 * @package Excent\Cloudpayments\CardPayment
 * @see     https://developers.cloudpayments.ru/#otmena-oplaty
 */
class PaymentsVoid extends BaseRequest
{
    public int $transactionId;

    /**
     * PaymentsVoid constructor.
     *
     * @param  int  $transactionId
     */
    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
