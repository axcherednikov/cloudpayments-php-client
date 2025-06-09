<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Типы агента
 * https://developers.cloudkassir.ru/#agentsign.
 */
enum Answer: int
{
    /**
     * Платеж может быть проведен
     * Система выполнит авторизацию платежа.
     */
    case OK = 0;

    /**
     * Неверный номер заказа
     * Платеж будет отклонен.
     */
    case WRONG_ID = 10;

    /**
     * Некорректный AccountId
     * Платеж будет отклонен.
     */
    case WRONG_USER = 11;

    /**
     * Неверная сумма
     * Платеж будет отклонен.
     */
    case WRONG_SUM = 12;

    /**
     * Платеж не может быть принят
     * Платеж будет отклонен.
     */
    case CANT_ACCEPT = 13;

    /**
     * Платеж просрочен
     * Платеж будет отклонен, плательщик получит соответствующее уведомление.
     */
    case OVERDUE = 20;
}
