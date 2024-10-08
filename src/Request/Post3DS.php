<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class Post3DS.
 *
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
