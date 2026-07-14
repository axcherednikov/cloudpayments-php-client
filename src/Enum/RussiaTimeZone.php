<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Часовые зоны места расчёта в формате RTZ для CustomerReceipt.
 */
enum RussiaTimeZone: int
{
    /** Калининград (EET). */
    case RTZ_1 = 1;

    /** Волгоград, Москва, Санкт-Петербург, Минск (MSK). */
    case RTZ_2 = 2;

    /** Ижевск, Самара (SAMT). */
    case RTZ_3 = 3;

    /** Екатеринбург (YEKT). */
    case RTZ_4 = 4;

    /** Новосибирск (NOVT). */
    case RTZ_5 = 5;

    /** Красноярск (KRAT). */
    case RTZ_6 = 6;

    /** Иркутск (IRKT). */
    case RTZ_7 = 7;

    /** Якутск (YAKT). */
    case RTZ_8 = 8;

    /** Владивосток, Магадан (VLAT). */
    case RTZ_9 = 9;

    /** Чокурдах (SAKT). */
    case RTZ_10 = 10;

    /** Анадырь, Петропавловск-Камчатский (ANAT). */
    case RTZ_11 = 11;
}
