<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;
use Excent\Cloudpayments\Exceptions\BadTypeException;

/**
 * Class PaymentsRefund
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#vozvrat-deneg
 */
class PaymentsRefund extends BaseRequest
{
    /**
     * @var int|float
     */
    public $amount;
    public int $transactionId;
    public ?string $jsonData;

    /**
     * PaymentsRefund constructor.
     *
     * @param  int  $transactionId
     * @param       $amount
     * @throws BadTypeException
     */
    public function __construct(int $transactionId, $amount)
    {
        if (! is_numeric($amount)) {
            throw new BadTypeException('Amount isn\'t numeric');
        }
        $this->amount = $amount;
        $this->transactionId = $transactionId;
    }
}
