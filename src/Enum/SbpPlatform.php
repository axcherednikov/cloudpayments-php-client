<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Платформа клиента для получения списка участников СБП.
 */
enum SbpPlatform: string
{
    case DESKTOP = 'desktop';
    case IOS = 'ios';
    case ANDROID = 'android';
}
