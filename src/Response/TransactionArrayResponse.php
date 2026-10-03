<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use stdClass;

/**
 * Class TransactionArrayResponse.
 */
class TransactionArrayResponse extends CloudResponse
{
    /**
     * @var TransactionModel[]
     */
    public mixed $model = [];

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
        $models = [];

        if (! is_array($modelDate)) {
            throw new ResponseFormatException('Transaction list model must be an array.');
        }

        foreach ($modelDate as $value) {
            if (! $value instanceof stdClass) {
                throw new ResponseFormatException('Each transaction list entry must be an object.');
            }

            $models[] = new TransactionModel($value);
        }

        $this->model = $models;
    }
}
