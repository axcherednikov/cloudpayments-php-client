<?php

namespace Excent\Cloudpayments\Response\Models;

/**
 * Class NotificationModel
 *
 * @package Excent\Cloudpayments\Response\Models
 */
class NotificationModel extends BaseModel
{
    public ?bool $isEnabled = null;
    public ?string $address = null;
    public ?string $httpMethod = null;
    public ?string $encoding = null;
    public ?string $format = null;
}
