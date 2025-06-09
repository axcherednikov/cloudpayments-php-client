<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Язык уведомлений после ссылки на оплату
 * https://developers.cloudkassir.ru/#agentsign.
 */
enum CultureName: string
{
    /**
     * Русский.
     */
    case RU = 'ru-RU';

    /**
     * Английский.
     */
    case EN = 'en-US';
}
