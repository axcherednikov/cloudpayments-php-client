<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response\Models;

final class ChargebackModel extends BaseModel
{
    public string $chargeBackId;
    public string $terminalUrl;
    public int $transactionId;
    public int|float $amount;
    public string $currency;
    public string $type;
    public string $operation;
    public string $card;
    public string $gateway;
    public string $date;
}
