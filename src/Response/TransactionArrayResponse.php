<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TransactionModel;

/**
 * Class TransactionArrayResponse.
 */
class TransactionArrayResponse extends CloudResponse
{
    /** @var TransactionModel[] */
    public $model;

    public function fillModel($modelDate): void
    {
        $models = [];

        if (is_array($modelDate)) {
            foreach ($modelDate as $value) {
                $model = new TransactionModel();
                $model->fill($value);

                $models[] = $model;
            }
        }

        $this->model = $models;
    }
}
