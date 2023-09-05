<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class CardsTopUp.
 *
 * @see     https://developers.cloudpayments.ru/#oplata-po-kriptogramme
 */
class CardsTopUp extends BaseRequest
{
    public string $name;
    public string $cardCryptogramPacket;
    public int|float $amount;
    public string $accountId;
    public string $currency;
    public ?string $email = null;
    public ?string $jsonData = null;
    public ?string $invoiceId = null;
    public ?string $description = null;
    public ?array $payer = null;
    public ?array $receiver = null;
}
