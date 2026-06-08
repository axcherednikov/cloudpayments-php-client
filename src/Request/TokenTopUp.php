<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class TokenTopUp.
 *
 * @see     https://developers.cloudpayments.ru/#vyplata-po-tokenu
 */
class TokenTopUp extends BaseRequest
{
    public string $token;
    /**
     * @var int|float
     */
    public $amount;
    public string $accountId;
    public string $currency;
    public ?string $invoiceId = null;
    /**
     * @var array<string, mixed>|null
     */
    public ?array $payer = null;
    /**
     * @var array<string, mixed>|null
     */
    public ?array $receiver = null;
}
