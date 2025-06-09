<?php

namespace Excent\Cloudpayments\Response\Models;

use stdClass;

/**
 * Class BaseModel.
 */
class BaseModel
{
    public function fill(stdClass $fillData): void
    {
        $props = get_object_vars($fillData);

        foreach ($props as $key => $value) {
            $lowerKey = lcfirst($key);
            $this->{$lowerKey} = $value;
        }
    }
}
