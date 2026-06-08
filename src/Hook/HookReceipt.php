<?php

namespace Excent\Cloudpayments\Hook;

/**
 * Class HookReceipt.
 */
class HookReceipt extends BaseHook
{
    /**
     * @var int|string|null
     */
    public $id;
    /**
     * @var int|string|null
     */
    public $documentNumber;
    /**
     * @var int|string|null
     */
    public $sessionNumber;
    /**
     * @var int|string|null
     */
    public $number;
    /**
     * @var int|string|null
     */
    public $fiscalSign;
    /**
     * @var string|null
     */
    public $deviceNumber;
    /**
     * @var string|null
     */
    public $regNumber;
    /**
     * @var string|null
     */
    public $fiscalNumber;
    /**
     * @var string|null
     */
    public $inn;
    /**
     * @var string|null
     */
    public $type;
    /**
     * @var string|null
     */
    public $ofd;
    /**
     * @var string|null
     */
    public $url;
    /**
     * @var string|null
     */
    public $qrCodeUrl;
    /**
     * @var int|null
     */
    public $transactionId;
    /**
     * @var float|int|string|null
     */
    public $amount;
    /**
     * @var string|null
     */
    public $dateTime;
    /**
     * @var string|null
     */
    public $invoiceId;
    /**
     * @var string|null
     */
    public $accountId;
    /**
     * @var array<string, mixed>|string|null
     */
    public $receipt;
    /**
     * @var string|null
     */
    public $calculationPlace;
    /**
     * @var string|null
     */
    public $settlePlace;
}
