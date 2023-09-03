<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\AppleSessionModel;
use stdClass;

/**
 * Class NotificationResponse.
 */
class AppleSessionResponse extends CloudResponse
{
    /** @var AppleSessionModel */
    public $model;

    /**
     * @inheritdoc
     * @param  stdClass  $modelDate
     */
    public function fillModel($modelDate)
    {
        $model = new AppleSessionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
