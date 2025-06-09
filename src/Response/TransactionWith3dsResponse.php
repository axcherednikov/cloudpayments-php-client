<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TransactionWith3dsModel;

/**
 * Class TransactionResponse.
 */
class TransactionWith3dsResponse extends CloudResponse
{
    /** @var TransactionWith3dsModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new TransactionWith3dsModel();
        $model->fill($modelDate);

        $this->model = $model;
    }

    /**
     * Нужна ли 3-D Secure аутентификация.
     */
    public function is3dsError(): bool
    {
        return $this->model->paReq !== null && $this->model->acsUrl !== null;
    }
}
