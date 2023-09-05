<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\NotificationModel;

/**
 * Class NotificationResponse.
 */
class NotificationResponse extends CloudResponse
{
    /** @var NotificationModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new NotificationModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
