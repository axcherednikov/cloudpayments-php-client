<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\NotificationModel;
use stdClass;

/**
 * Class NotificationResponse.
 */
class NotificationResponse extends CloudResponse
{
    /**
     * @var NotificationModel|null
     */
    public mixed $model = null;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new NotificationModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
