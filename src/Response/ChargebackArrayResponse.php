<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\ChargebackModel;
use stdClass;

final class ChargebackArrayResponse extends CloudResponse
{
    /** @var ChargebackModel[] */
    public $model = [];

    /**
     * @param mixed $modelDate
     */
    public function fillModel($modelDate): void
    {
        if (! is_array($modelDate)) {
            $this->model = [];

            return;
        }

        $models = [];

        foreach ($modelDate as $value) {
            if (! $value instanceof stdClass) {
                continue;
            }

            $model = new ChargebackModel();
            $model->fill($value);
            $models[] = $model;
        }

        $this->model = $models;
    }
}
