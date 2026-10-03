<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\AppleSessionModel;
use stdClass;

/**
 * Class NotificationResponse.
 */
class AppleSessionResponse extends CloudResponse
{
    /**
     * @var AppleSessionModel|null
     */
    public mixed $model = null;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new AppleSessionModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
