<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Список методов
 * https://developers.cloudpayments.ru/#api
 * https://developers.cloudkassir.ru/#api-kassy.
 */
enum CloudMethodsEnum: string
{
    /** Проверка платежа по номеру заказа */
    case PAYMENTS_FIND = 'payments/find';

    /** Проверка платежа */
    case PAYMENTS_GET = 'payments/get';

    /** Создание оплаты по токену при двухшаговой оплате */
    case PAYMENTS_TOKENS_AUTH = 'payments/tokens/auth';

    /** Создание оплаты по карте при двухшаговой оплате */
    case PAYMENTS_CARDS_AUTH = 'payments/cards/auth';

    /** обработка 3Ds */
    case PAYMENTS_CARDS_POST3DS = 'payments/cards/post3ds';

    /** Проведение оплаты по токену при одношаговой оплате */
    case PAYMENTS_TOKENS_CHARGE = 'payments/tokens/charge';

    /** Подтверждение оплаты */
    case PAYMENTS_CONFIRM = 'payments/confirm';

    /** Список транзакций за определенное время */
    case PAYMENTS_LIST = 'payments/list';

    /** Отмена оплаты */
    case PAYMENTS_VOID = 'payments/void';

    /** Старт сессии Applepay */
    case APPLEPAY_STARTSESSION = 'applepay/startsession';

    /** Возврат средств */
    case PAYMENTS_REFUND = 'payments/refund';

    /** Метод для оплаты по криптограмме платежных данных для одностадийного платежа */
    case PAYMENTS_CARDS_CHARGE = 'payments/cards/charge';

    /** Выплата по криптограмме */
    case PAYMENTS_CARDS_TOPUP = 'payments/cards/topup';

    /** Выплата по токену */
    case PAYMENTS_TOKEN_TOPUP = 'payments/token/topup';

    /** Метод выгрузки списка всех платежных токенов */
    case PAYMENTS_TOKENS_LIST = 'payments/tokens/list';

    /** Метод создания подписки на рекуррентные платежи */
    case SUBSCRIPTIONS_CREATE = 'subscriptions/create';

    /** Метод получения информации о статусе подписки */
    case SUBSCRIPTIONS_GET = 'subscriptions/get';

    /** Метод получения списка подписок для определенного аккаунта */
    case SUBSCRIPTIONS_FIND = 'subscriptions/find';

    /** Метод изменения ранее созданной подписки */
    case SUBSCRIPTIONS_UPDATE = 'subscriptions/update';

    /** Метод отмены подписки на рекуррентные платежи */
    case SUBSCRIPTIONS_CANCEL = 'subscriptions/cancel';

    /** Создание счета для отправки по почте */
    case ORDERS_CREATE = 'orders/create';

    /** Метод отмены созданного счета */
    case ORDERS_CANCEL = 'orders/cancel';

    /** Создание чека */
    case KKT_RECEIPT = 'kkt/receipt';
}
