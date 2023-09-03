<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\NotificationModel;
use stdClass;

/**
 * Class NotificationResponse.
 */
class NotificationResponse extends CloudResponse
{
    /** @var NotificationModel */
    public $model;

    /**
     * @inheritdoc
     * @param  stdClass  $modelDate
     */
    public function fillModel($modelDate)
    {
        $model = new NotificationModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
