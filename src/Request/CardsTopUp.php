<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class CardsTopUp
 *
 * @package Excent\Cloudpayments\CardPayment
 * @see     https://developers.cloudpayments.ru/#oplata-po-kriptogramme
 */
class CardsTopUp extends BaseRequest
{
    public string $name;
    public string $cardCryptogramPacket;
    public int|float $amount;
    public string $accountId;
    public string $currency;
    public ?string $email;
    public ?string $jsonData;
    public ?string $invoiceId;
    public ?string $description;
    public ?array $payer;
    public ?array $receiver;
}
