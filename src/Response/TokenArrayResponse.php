<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TokenModel;
use stdClass;

/**
 * Class TokenArrayResponse.
 */
class TokenArrayResponse extends CloudResponse
{
    /**
     * @var TokenModel[]|null
     */
    public mixed $model = null;

    /**
     * @param mixed $modelDate
     */
    public function fillModel($modelDate): void
    {
        $models = [];

        if (is_array($modelDate)) {
            foreach ($modelDate as $value) {
                /**
                 * @var stdClass $value
                 */
                $model = new TokenModel();
                $model->fill($value);

                $models[] = $model;
            }
        }

        $this->model = $models;
    }
}
