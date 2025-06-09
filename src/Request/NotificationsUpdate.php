<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class NotificationsUpdate.
 *
 * @see     https://developers.cloudpayments.ru/#izmenenie-nastroek-uvedomleniy
 */
class NotificationsUpdate extends BaseRequest
{
    /**
     * @see https://developers.cloudpayments.ru/#tipy-operatsiy
     * @var string
     */
    public string $type;
    public ?bool $isEnabled = null;
    public ?string $address = null;
    public ?string $httpMethod = null;
    public ?string $encoding = null;
    public ?string $format = null;
}
