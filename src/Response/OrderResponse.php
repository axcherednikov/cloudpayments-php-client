<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\OrderModel;
use stdClass;

/**
 * Class SubscriptionResponse.
 */
class OrderResponse extends CloudResponse
{
    /**
     * @var OrderModel|null
     */
    public mixed $model = null;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new OrderModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
