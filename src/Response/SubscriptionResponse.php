<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\SubscriptionModel;
use stdClass;

/**
 * Class SubscriptionResponse.
 */
class SubscriptionResponse extends CloudResponse
{
    /** @var SubscriptionModel */
    public $model;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new SubscriptionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
