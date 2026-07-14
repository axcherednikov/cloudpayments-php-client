<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Тип устройства плательщика для оплаты через СБП.
 */
enum Device: string
{
    case MOBILE_APP = 'MobileApp';
    case DESKTOP_WEB = 'DesktopWeb';
    case MOBILE = 'Mobile';
}
