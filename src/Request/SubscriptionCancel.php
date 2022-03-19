<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionCancel
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#otmena-podpiski-na-rekurrentnye-platezhi
 */
class SubscriptionCancel extends BaseRequest
{
    public string $id;
}
