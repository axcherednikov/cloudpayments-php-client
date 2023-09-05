<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Enum\BoolField;

/**
 * Базовый класс моделей фондю
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * Данные в нужном для запроса формате.
     *
     * @return array<string, mixed>
     */
    public function asArray(): array
    {
        $data = [];

        $fields = get_object_vars($this);

        foreach ($fields as $field => $value) {
            $key = ucfirst($field);

            if ($value === true) {
                $value = BoolField::TRUE->value;
            }

            if ($value === false) {
                $value = BoolField::FALSE->value;
            }

            if ($value !== null) {
                $data[$key] = $value;
            }

            if ($value instanceof self) {
                $data[$key] = $value->asArray();
            }

            if (is_array($value)) {
                $computed = [];

                foreach ($value as $item) {
                    if ($item instanceof self) {
                        $item = $item->asArray();
                    }

                    $computed[] = $item;
                }

                $data[$key] = $computed;
            }
        }

        return $data;
    }
}
