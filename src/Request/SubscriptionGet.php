<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionGet.
 *
 * @see     https://developers.cloudpayments.ru/#zapros-informatsii-o-podpiske
 */
class SubscriptionGet extends BaseRequest
{
    public string $id;
}
