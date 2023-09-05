<?php

namespace Excent\Cloudpayments\Hook;

/**
 * Базовый класс моделей фондю
 * Class BaseModel.
 *
 * @property string $response_status
 */
class BaseHook
{
    public function __construct(protected array $request)
    {
        $this->fill();
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    private function fill(): void
    {
        $modelFields = get_object_vars($this);

        foreach ($modelFields as $key => $field) {
            $requestKey = ucfirst($key);

            if (isset($this->request[$requestKey])) {
                $this->$key = $this->request[$requestKey];
            }
        }
    }
}
