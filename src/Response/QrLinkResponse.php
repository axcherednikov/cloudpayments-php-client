<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\QrLinkModel;
use stdClass;

/**
 * Ответ на создание ссылки или QR-кода для оплаты через СБП.
 */
class QrLinkResponse extends CloudResponse
{
    /** @var QrLinkModel */
    public $model;

    /**
     * @param stdClass $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = new QrLinkModel();
        $model->fill($modelDate);

        $this->model = $model;
    }
}
