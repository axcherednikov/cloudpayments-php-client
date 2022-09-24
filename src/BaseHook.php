<?php

namespace Excent\Cloudpayments;

/**
 * Базовый класс моделей фондю
 * Class BaseModel
 *
 * @package Excent\Cloudpayments
 * @property string $response_status
 */
class BaseHook
{
    protected array $request;

    public function __construct(array $request)
    {
        $this->request = $request;

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
