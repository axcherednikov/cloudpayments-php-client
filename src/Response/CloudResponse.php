<?php

namespace Excent\Cloudpayments\Response;

use Excent\Cloudpayments\Response\Models\BaseModel;
use Psr\Http\Message\ResponseInterface;
use stdClass;

/**
 * Class CloudResponse.
 */
class CloudResponse
{
    public bool $success;
    public ?string $message = null;
    public ?string $warning = null;

    public $model;

    /**
     * Заполняет по респонсу.
     */
    public function fillByResponse(ResponseInterface $response): self
    {
        $responseContent = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

        $this->success = $responseContent->Success ?? false;
        $this->message = $responseContent->Message ?? 'Message is not set';
        $this->warning = $responseContent->Warning ?? 'Warning is not set';

        if (! empty($responseContent->Model)) {
            $this->fillModel($responseContent->Model);
        }

        return $this;
    }

    /**
     * Заполняет model свойство.
     */
    public function fillModel($modelDate): void
    {
        $model = $modelDate;

        if (is_object($modelDate)) {
            $model = new BaseModel();
            $model->fill($modelDate);
        }

        $this->model = $model;
    }
}
