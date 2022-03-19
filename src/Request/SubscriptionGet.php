<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionGet
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#zapros-informatsii-o-podpiske
 *
 */
class SubscriptionGet extends BaseRequest
{
    public string $id;
}
