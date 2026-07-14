<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Схемы проведения платежа через СБП.
 */
enum SbpScheme: string
{
    case CHARGE = 'charge';
}
