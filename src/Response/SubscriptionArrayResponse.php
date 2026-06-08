<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\SubscriptionModel;
use stdClass;

/**
 * Class SubscriptionArrayResponse.
 */
class SubscriptionArrayResponse extends CloudResponse
{
    /** @var SubscriptionModel[] */
    public $model;

    /**
     * @param mixed $modelDate
     */
    public function fillModel($modelDate): void
    {
        $models = [];

        if (is_array($modelDate)) {
            foreach ($modelDate as $value) {
                /** @var stdClass $value */
                $model = new SubscriptionModel();
                $model->fill($value);

                $models[] = $model;
            }
        }

        $this->model = $models;
    }
}
