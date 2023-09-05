<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\KktReceiptModel;

/**
 * Class KktReceiptResponse.
 */
class KktReceiptResponse extends CloudResponse
{
    /** @var KktReceiptModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new KktReceiptModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
