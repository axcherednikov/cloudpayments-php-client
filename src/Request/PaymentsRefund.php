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
    public float $amount;

    public ?string $jsonData = null;

    /**
     * PaymentsRefund constructor.
     *
     * @throws BadTypeException
     */
    public function __construct(public int $transactionId, string|int|float $amount)
    {
        if (! is_numeric($amount)) {
            throw new BadTypeException('Amount isn\'t numeric');
        }

        $this->amount = (float) $amount;
    }
}
