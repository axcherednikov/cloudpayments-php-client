<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Признак способа расчета.
 * https://developers.cloudkassir.ru/#vat.
 */
enum Vat: int
{
    /**
     * НДС не облагается.
     */
    final public const WITHOUT_VAT = null;

    /**
     * НДС не облагается.
     */
    case PERCENT_0 = 0;

    /**
     * 10% НДС
     */
    case PERCENT_10 = 10;

    /**
     * 20% НДС
     */
    case PERCENT_20 = 20;

    /**
     * Расчетный НДС 10/110.
     */
    case PERCENT_110 = 110;

    /**
     * Расчетный НДС 20/120.
     */
    case PERCENT_120 = 120;

    /**
     * НДС 12% (только для онлайн-касс в Казахстане).
     */
    case PERCENT_12 = 12;
}
