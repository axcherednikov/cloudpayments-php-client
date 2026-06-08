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

    /** @var mixed */
    public $model;

    /**
     * Заполняет по респонсу.
     */
    public function fillByResponse(ResponseInterface $response): self
    {
        $responseContent = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

        if (! $responseContent instanceof stdClass) {
            $responseContent = new stdClass();
        }

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
     *
     * @param mixed $modelDate
     */
    public function fillModel($modelDate): void
    {
        $model = $modelDate;

        if ($modelDate instanceof stdClass) {
            $model = new BaseModel();
            $model->fill($modelDate);
        }

        $this->model = $model;
    }
}
