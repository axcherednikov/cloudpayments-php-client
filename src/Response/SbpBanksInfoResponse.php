<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\SbpBanksInfoModel;
use stdClass;

/**
 * Ответ со списком участников СБП.
 */
class SbpBanksInfoResponse extends CloudResponse
{
    /** @var SbpBanksInfoModel[] */
    public $model = [];

    /**
     * @param mixed $modelDate
     */
    public function fillModel($modelDate): void
    {
        $models = [];

        if (is_array($modelDate)) {
            foreach ($modelDate as $value) {
                if (! $value instanceof stdClass) {
                    continue;
                }

                $model = new SbpBanksInfoModel();
                $model->fill($value);
                $models[] = $model;
            }
        }

        $this->model = $models;
    }
}
