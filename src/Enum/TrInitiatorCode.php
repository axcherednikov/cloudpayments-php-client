<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

enum TrInitiatorCode: int
{
    /**
     * Транзакция инициирована ТСП на основе ранее сохраненных учетных данных.
     */
    case SAVED_CREDENTIALS = 0;

    /**
     * Транзакция инициирована держателем карты (клиентом) на основе ранее сохраненных учетных данных.
     */
    case BY_CARDHOLDER = 1;
}
