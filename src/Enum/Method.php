<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Признак способа расчета.
 * https://developers.cloudkassir.ru/#method.
 */
enum Method: int
{
    /**
     * Unknown, неизвестный способ расчета.
     */
    case UNKNOWN = 0;

    /**
     * FullPrepayment, предоплата 100%.
     */
    case FULL_PREPAYMENT = 1;

    /**
     * PartialPrepayment, предоплата.
     */
    case PARTIAL_PREPAYMENT = 2;

    /**
     * AdvancePay, аванс
     */
    case ADVANCE_PAY = 3;

    /**
     * FullPay, полный расчёт
     */
    case FULL_PAY = 4;

    /**
     * PartialPayAndCredit, частичный расчёт и кредит
     */
    case PARTIAL_PAY_AND_CREDIT = 5;

    /**
     * Credit, передача в кредит
     */
    case CREDIT = 6;

    /**
     * CreditPayment, оплата кредита.
     */
    case CREDIT_PAYMENT = 7;
}
