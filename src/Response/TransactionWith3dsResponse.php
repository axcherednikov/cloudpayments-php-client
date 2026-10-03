<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Response\Models\TransactionWith3dsModel;
use stdClass;

/**
 * Class TransactionResponse.
 */
class TransactionWith3dsResponse extends CloudResponse
{
    /**
     * @var TransactionWith3dsModel|null
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

        $model = new TransactionWith3dsModel($modelDate);
        $this->model = $model;
    }

    /**
     * Нужна ли 3-D Secure аутентификация.
     */
    public function is3dsError(): bool
    {
        return $this->model instanceof TransactionWith3dsModel
            && $this->model->paReq !== null
            && $this->model->acsUrl !== null;
    }
}
