<?php

namespace Excent\Cloudpayments\Enum;

use MyCLabs\Enum\Enum;

/**
 * Язык уведомлений после ссылки на оплату
 * https://developers.cloudkassir.ru/#agentsign.
 *
 * @see Enum
 */
class CultureName extends Enum
{
    /**
     * Русский.
     *
     * @var string
     */
    final public const RU = 'ru-RU';

    /**
     * Английский.
     *
     * @var string
     */
    final public const EN = 'en-US';
}
