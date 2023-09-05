<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class SubscriptionCancel.
 *
 * @see     https://developers.cloudpayments.ru/#otmena-podpiski-na-rekurrentnye-platezhi
 */
class SubscriptionCancel extends BaseRequest
{
    public string $id;
}
