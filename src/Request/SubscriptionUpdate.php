<?php

namespace Excent\Cloudpayments\Request;

use DateTime;
use Excent\Cloudpayments\BaseRequest;

/**
 * Class SubscriptionUpdate
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#izmenenie-podpiski-na-rekurrentnye-platezhi
 */
class SubscriptionUpdate extends BaseRequest
{
    public string $id;
    public ?string $description;
    /**
     * @var int|float
     */
    public $amount;
    public ?string $currency;
    public ?bool $requireConfirmation;
    /**
     * "startDate":"2014-08-06T16:46:29.5377246Z",
     * @var DateTime|null
     */
    public ?DateTime $startDate;
    public ?string $interval;
    public ?int $period;
    public ?int $maxPeriods;
    public ?string $customerReceipt;
    public ?string $cultureName;
}
