<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;

/**
 * Class PaymentsRefund.
 *
 * @see     https://developers.cloudpayments.ru/#vozvrat-deneg
 */
class PaymentsRefund extends BaseRequest
{
    /**
     * @var int|float
     */
    public $amount;
    public ?string $jsonData = null;

    /**
     * PaymentsRefund constructor.
     *
     * @param       $amount
     * @throws BadTypeException
     */
    public function __construct(public int $transactionId, $amount)
    {
        if (! is_numeric($amount)) {
            throw new BadTypeException('Amount isn\'t numeric');
        }
        $this->amount = $amount;
    }
}
