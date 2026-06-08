<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\KktReceiptModel;
use stdClass;

/**
 * Class KktReceiptResponse.
 */
class KktReceiptResponse extends CloudResponse
{
    /** @var KktReceiptModel */
    public $model;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new KktReceiptModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
