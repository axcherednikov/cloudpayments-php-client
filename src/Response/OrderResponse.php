<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\OrderModel;
use stdClass;

/**
 * Class SubscriptionResponse.
 */
class OrderResponse extends CloudResponse
{
    /** @var OrderModel */
    public $model;

    /**
     * @inheritdoc
     * @param  stdClass  $modelDate
     */
    public function fillModel($modelDate)
    {
        $model = new OrderModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
