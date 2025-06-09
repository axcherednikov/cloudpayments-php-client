<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Bool-значения для клауда
 * https://developers.cloudkassir.ru/#agentsign.
 */
enum BoolField: string
{
    case TRUE = 'true';

    case FALSE = 'false';
}
