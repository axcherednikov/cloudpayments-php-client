<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class NotificationsGet.
 *
 * @see     https://developers.cloudpayments.ru/#prosmotr-tranzaktsii
 */
class NotificationsGet extends BaseRequest
{
    /**
     * @see https://developers.cloudpayments.ru/#tipy-operatsiy
     * @var string
     */
    public string $type;
}
