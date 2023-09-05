<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class SubscriptionGet.
 *
 * @see     https://developers.cloudpayments.ru/#zapros-informatsii-o-podpiske
 */
class SubscriptionGet extends BaseRequest
{
    public string $id;
}
