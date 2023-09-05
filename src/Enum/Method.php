<?php

namespace Excent\Cloudpayments\Enum;

use MyCLabs\Enum\Enum;

/**
 * Признак способа расчета.
 * https://developers.cloudkassir.ru/#method.
 *
 * @see Enum
 */
class Method extends Enum
{
    /**
     * Unknown, неизвестный способ расчета.
     *
     * @var int
     */
    final public const UNKNOWN = 0;

    /**
     * FullPrepayment, предоплата 100%.
     *
     * @var int
     */
    final public const FULL_PREPAYMENT = 1;

    /**
     * PartialPrepayment, предоплата.
     *
     * @var int
     */
    final public const PARTIAL_PREPAYMENT = 2;

    /**
     * AdvancePay, аванс
     *
     * @var int
     */
    final public const ADVANCE_PAY = 3;

    /**
     * FullPay, полный расчёт
     *
     * @var int
     */
    final public const FULL_PAY = 4;

    /**
     * PartialPayAndCredit, частичный расчёт и кредит
     *
     * @var int
     */
    final public const PARTIAL_PAY_AND_CREDIT = 5;

    /**
     * Credit, передача в кредит
     *
     * @var int
     */
    final public const CREDIT = 6;

    /**
     * CreditPayment, оплата кредита.
     *
     * @var int
     */
    final public const CREDIT_PAYMENT = 7;
}
