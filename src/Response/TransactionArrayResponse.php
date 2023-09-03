<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TransactionModel;
use stdClass;

/**
 * Class TransactionArrayResponse.
 */
class TransactionArrayResponse extends CloudResponse
{
    /** @var TransactionModel[] */
    public $model;

    /**
     * @inheritdoc
     * @param  stdClass  $modelDate
     */
    public function fillModel($modelDate)
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
