<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\OrderModel;

/**
 * Class SubscriptionResponse.
 */
class OrderResponse extends CloudResponse
{
    /** @var OrderModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new OrderModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
