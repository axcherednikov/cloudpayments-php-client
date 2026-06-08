<?php

namespace Excent\Cloudpayments\Response\Models;

use stdClass;

/**
 * Class BaseModel.
 */
class BaseModel
{
    /** @var array<string, mixed> */
    private array $additionalProperties = [];

    public function fill(stdClass $fillData): void
    {
        $props = get_object_vars($fillData);
        $knownProperties = $this->getKnownProperties();

        foreach ($props as $key => $value) {
            $lowerKey = lcfirst($key);

            if (isset($knownProperties[$lowerKey])) {
                $this->{$lowerKey} = $value;

                continue;
            }

            $this->additionalProperties[$lowerKey] = $value;
        }
    }

    /**
     * @return array<string, true>
     */
    private function getKnownProperties(): array
    {
        $properties = get_class_vars(static::class);
        unset($properties['additionalProperties']);

        return array_fill_keys(array_keys($properties), true);
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdditionalProperties(): array
    {
        return $this->additionalProperties;
    }
}
