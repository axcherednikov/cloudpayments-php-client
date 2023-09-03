<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionFind.
 *
 * @see     https://developers.cloudpayments.ru/#poisk-podpisok
 */
class SubscriptionFind extends BaseRequest
{
    public string $accountId;
}
