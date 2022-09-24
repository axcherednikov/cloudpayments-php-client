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
    public function __construct(
        public int $transactionId
    ) {
    }
}
