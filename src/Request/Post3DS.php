<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class Post3DS
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#obrabotka-3-d-secure
 */
class Post3DS extends BaseRequest
{
    public function __construct(
        public int $transactionId,
        public string $paRes
    ) {
    }
}
