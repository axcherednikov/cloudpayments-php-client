<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TransactionModel;

/**
 * Class TransactionResponse.
 *
 * @extends TransactionResponse
 */
class TransactionResponse extends CloudResponse
{
    /** @var TransactionModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new TransactionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
