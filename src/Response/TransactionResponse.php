<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TransactionModel;
use stdClass;

/**
 * Class TransactionResponse.
 */
class TransactionResponse extends CloudResponse
{
    /** @var TransactionModel */
    public $model;

    /**
     * @inheritdoc
     * @param  stdClass  $modelDate
     */
    public function fillModel($modelDate)
    {
        $model = new TransactionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
