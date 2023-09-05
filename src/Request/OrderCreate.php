<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;

/**
 * Class OrderCreate.
 *
 * @see     https://developers.cloudpayments.ru/#sozdanie-scheta-dlya-otpravki-po-pochte
 */
class OrderCreate extends BaseRequest
{
    /**
     * @var int|float
     */
    public $amount;
    public ?string $email = null;
    public ?bool $requireConfirmation = null;
    public ?bool $sendEmail = null;
    public ?string $invoiceId = null;
    public ?string $accountId = null;
    public ?string $offerUri = null;
    public ?string $phone = null;
    public ?bool $sendSms = null;
    public ?bool $sendViber = null;
    public ?string $cultureName = null;
    public ?string $subscriptionBehavior = null;
    public ?string $successRedirectUrl = null;
    public ?string $failRedirectUrl = null;
    public ?string $jsonData = null;

    /**
     * OrderCreate constructor.
     *
     * @param          $amount
     * @throws BadTypeException
     */
    public function __construct($amount, public string $currency, public string $description)
    {
        if (! is_numeric($amount)) {
            throw new BadTypeException('Amount isn\'t numeric');
        }
        $this->amount = $amount;
    }
}
