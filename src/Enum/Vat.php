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
     * 5% НДС.
     */
    case PERCENT_5 = 5;

    /**
     * 7% НДС.
     */
    case PERCENT_7 = 7;

    /**
     * 10% НДС
     */
    case PERCENT_10 = 10;

    /**
     * 20% НДС
     */
    case PERCENT_20 = 20;

    /**
     * 22% НДС с 1 января 2026 года.
     */
    case PERCENT_22 = 22;

    /**
     * Расчетный НДС 10/110.
     */
    case PERCENT_110 = 110;

    /**
     * Расчетный НДС 5/105.
     */
    case PERCENT_105 = 105;

    /**
     * Расчетный НДС 7/107.
     */
    case PERCENT_107 = 107;

    /**
     * Расчетный НДС 20/120.
     */
    case PERCENT_120 = 120;

    /**
     * Расчетный НДС 22/122 с 1 января 2026 года.
     */
    case PERCENT_122 = 122;

    /**
     * НДС 12% (только для онлайн-касс в Казахстане).
     */
    case PERCENT_12 = 12;
}
