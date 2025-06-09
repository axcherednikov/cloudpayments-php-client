<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;

/**
 * Class PaymentsConfirm.
 *
 * @see     https://developers.cloudpayments.ru/#podtverzhdenie-oplaty
 */
class PaymentsConfirm extends BaseRequest
{
    /**
     * @var int|float
     */
    public $amount;
    public ?string $jsonData = null;

    /**
     * PaymentsConfirm constructor.
     *
     * @param  int|float    $amount
     * @param  string|null  $jsonData
     * @throws BadTypeException
     */
    public function __construct($amount, public int $transactionId, ?string $jsonData = null)
    {
        if (! is_numeric($amount)) {
            throw new BadTypeException('Amount isn\'t numeric');
        }

        $this->amount = $amount;

        if ($jsonData) {
            $this->jsonData = $jsonData;
        }
    }
}
