<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Типы чека по признаку расчета
 * https://developers.cloudkassir.ru/#type.
 */
enum ReceiptType: string
{
    /**
     * Приход
     * Выдается при получении средств от покупателя (клиента).
     */
    case INCOME = 'Income';

    /**
     * Возврат прихода.
     * Выдается при возврате покупателю (клиенту) средств, полученных от него.
     */
    case INCOME_RETURN = 'IncomeReturn';

    /**
     * Расход
     * Выдается при выдаче средств покупателю (клиенту).
     */
    case EXPENSE = 'Expense';

    /**
     * Возврат расхода
     * Выдается при получении средств от покупателя (клиента), выданных ему.
     */
    case EXPENSE_RETURN = 'ExpenseReturn';
}
