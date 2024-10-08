<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\TokenModel;

/**
 * Class TokenArrayResponse.
 */
class TokenArrayResponse extends CloudResponse
{
    /** @var TokenModel[] */
    public $model;

    public function fillModel($modelDate): void
    {
        $models = [];

        if (is_array($modelDate)) {
            foreach ($modelDate as $value) {
                $model = new TokenModel();
                $model->fill($value);

                $models[] = $model;
            }
        }

        $this->model = $models;
    }
}
