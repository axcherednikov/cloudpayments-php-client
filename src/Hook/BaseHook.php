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
    /**
     * @param array<string, mixed> $request
     */
    public function __construct(protected array $request)
    {
        $this->fill();
    }

    /**
     * @return array<string, mixed>
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    private function fill(): void
    {
        $modelFields = get_object_vars($this);

        foreach ($modelFields as $key => $field) {
            $requestKey = ucfirst((string) $key);

            if (isset($this->request[$requestKey])) {
                $this->$key = $this->request[$requestKey];
            }
        }
    }
}
