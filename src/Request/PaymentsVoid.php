<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class PaymentsVoid.
 *
 * @see     https://developers.cloudpayments.ru/#otmena-oplaty
 */
class PaymentsVoid extends BaseRequest
{
    public function __construct(
        public int $transactionId
    ) {
    }
}
