<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionFind
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#poisk-podpisok
 *
 */
class SubscriptionFind extends BaseRequest
{
    public string $accountId;
}
