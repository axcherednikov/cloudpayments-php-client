<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

enum PaymentScheduled: int
{
    /**
     * Транзакция инициирована без расписания.
     */
    case WITHOUT_SCHEDULE = 0;

    /**
     * Транзакция инициирована по расписанию.
     */
    case WITH_SCHEDULE = 1;
}
