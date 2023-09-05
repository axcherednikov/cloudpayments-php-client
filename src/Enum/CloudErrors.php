<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Коды ошибок
 * https://developers.cloudpayments.ru/#kody-oshibok.
 */
enum CloudErrors: int
{
    /** Отказ эмитента проводить онлайн-операцию */
    case REFER_TO_CARD_ISSUER = 5001;

    /** Отказ эмитента проводить онлайн-операцию */
    case INVALID_MERCHANT = 5003;

    /** Карта потеряна */
    case PICK_UP_CARD = 5004;

    /** Отказ эмитента без объяснения причин */
    case DO_NOT_HONOR = 5005;

    /** Отказ сети проводить операцию или неправильный CVV-код */
    case ERROR = 5006;

    /** Карта потеряна */
    case PICK_UP_CARD_SPECIAL_CONDITIONS = 5007;

    /** Карта не предназначена для онлайн-платежей */
    case INVALID_TRANSACTION = 5012;

    /** Слишком маленькая или слишком большая сумма операции */
    case AMOUNT_ERROR = 5013;

    /** Некорректный номер карты */
    case INVALID_CARD_NUMBER = 5014;

    /** Эмитент не найден */
    case NO_SUCH_ISSUER = 5015;

    /** Отказ эмитента без объяснения причин */
    case TRANSACTION_ERROR = 5019;

    /** Ошибка на стороне эквайера — неверно сформирована транзакция */
    case FORMAT_ERROR = 5030;

    /** Неизвестный эмитент карты */
    case BANK_NOT_SUPPORTED_BY_SWITCH = 5031;

    /** Истек срок утери карты */
    case EXPIRED_CARD_PICKUP = 5033;

    /** Отказ эмитента — подозрение на мошенничество */
    case SUSPECTED_FRAUD = 5034;

    /** Карта не предназначена для платежей */
    case RESTRICTED_CARD = 5036;

    /** Карта потеряна */
    case LOST_CARD = 5041;

    /** Карта украдена */
    case STOLEN_CARD = 5043;

    /** Недостаточно средств */
    case INSUFFICIENT_FUNDS = 5051;

    /** Карта просрочена или неверно указан срок действия */
    case EXPIRED_CARD = 5054;

    /** Ограничение на карте */
    case TRANSACTION_NOT_PERMITTED = 5057;

    /** Транзакция была отклонена банком по подозрению в мошенничестве */
    case SUSPECTED_FRAUD_DECLINE = 5059;

    /** Карта не предназначена для платежей */
    case RESTRICTED_CARD_2 = 5062;

    /** Карта заблокирована из-за нарушений безопасности */
    case SECURITY_VIOLATION = 5063;

    /** Превышен лимит операций по карте */
    case EXCEED_WITHDRAWAL_FREQUENCY = 5065;

    /** Неверный CVV-код */
    case INCORRECT_CVV = 5082;

    /** Эмитент недоступен */
    case TIMEOUT = 5091;

    /** Эмитент недоступен */
    case CANNOT_REACH_NETWORK = 5092;

    /** Ошибка банка-эквайера или сети */
    case SYSTEM_ERROR = 5096;

    /** Операция не может быть обработана по прочим причинам */
    case UNABLE_TO_PROCESS = 5204;

    /** 3-D Secure авторизация не пройдена */
    case AUTHENTICATION_FAILED = 5206;

    /** 3-D Secure авторизация недоступна */
    case AUTHENTICATION_UNAVAILABLE = 5207;

    /** Лимиты эквайера на проведение операций */
    case ANTI_FRAUD = 5300;
}
