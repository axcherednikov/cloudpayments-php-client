<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class SubscriptionFind.
 *
 * @see     https://developers.cloudpayments.ru/#poisk-podpisok
 */
class SubscriptionFind extends BaseRequest
{
    public string $accountId;
}
