<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use stdClass;

/**
 * Class TransactionResponse.
 */
class TransactionResponse extends CloudResponse
{
    /**
     * @var TransactionModel|null
     */
    public mixed $model = null;

    protected function shouldFillModel(stdClass $responseContent): bool
    {
        return property_exists($responseContent, 'Model') && $responseContent->Model !== null;
    }

    /**
     * @param  mixed  $modelDate
     *
     * @throws ResponseFormatException
     */
    public function fillModel($modelDate): void
    {
        if (! $modelDate instanceof stdClass) {
            throw new ResponseFormatException('Transaction model must be an object.');
        }

        $model = new TransactionModel($modelDate);
        $this->model = $model;
    }
}
