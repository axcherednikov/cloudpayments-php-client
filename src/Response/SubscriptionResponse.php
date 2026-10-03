<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\SubscriptionModel;
use stdClass;

/**
 * Class SubscriptionResponse.
 */
class SubscriptionResponse extends CloudResponse
{
    /**
     * @var SubscriptionModel|null
     */
    public mixed $model = null;

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
