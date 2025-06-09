<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\AppleSessionModel;

/**
 * Class NotificationResponse.
 */
class AppleSessionResponse extends CloudResponse
{
    /** @var AppleSessionModel */
    public $model;

    public function fillModel($modelDate): void
    {
        $model = new AppleSessionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
