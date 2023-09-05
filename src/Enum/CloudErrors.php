<?php

namespace Excent\Cloudpayments\Enum;

use MyCLabs\Enum\Enum;

/**
 * Коды ошибок
 * https://developers.cloudpayments.ru/#kody-oshibok.
 *
 * @see Enum
 */
class CloudErrors extends Enum
{
    /** Отказ эмитента проводить онлайн-операцию */
    final public const REFER_TO_CARD_ISSUER = 5001;

    /** Отказ эмитента проводить онлайн-операцию */
    final public const INVALID_MERCHANT = 5003;

    /** Карта потеряна */
    final public const PICK_UP_CARD = 5004;

    /** Отказ эмитента без объяснения причин */
    final public const DO_NOT_HONOR = 5005;

    /** Отказ сети проводить операцию или неправильный CVV-код */
    final public const ERROR = 5006;

    /** Карта потеряна */
    final public const PICK_UP_CARD_SPECIAL_CONDITIONS = 5007;

    /** Карта не предназначена для онлайн-платежей */
    final public const INVALID_TRANSACTION = 5012;

    /** Слишком маленькая или слишком большая сумма операции */
    final public const AMOUNT_ERROR = 5013;

    /** Некорректный номер карты */
    final public const INVALID_CARD_NUMBER = 5014;

    /** Эмитент не найден */
    final public const NO_SUCH_ISSUER = 5015;

    /** Отказ эмитента без объяснения причин */
    final public const TRANSACTION_ERROR = 5019;

    /** Ошибка на стороне эквайера — неверно сформирована транзакция */
    final public const FORMAT_ERROR = 5030;

    /** Неизвестный эмитент карты */
    final public const BANK_NOT_SUPPORTED_BY_SWITCH = 5031;

    /** Истек срок утери карты */
    final public const EXPIRED_CARD_PICKUP = 5033;

    /** Отказ эмитента — подозрение на мошенничество */
    final public const SUSPECTED_FRAUD = 5034;

    /** Карта не предназначена для платежей */
    final public const RESTRICTED_CARD = 5036;

    /** Карта потеряна */
    final public const LOST_CARD = 5041;

    /** Карта украдена */
    final public const STOLEN_CARD = 5043;

    /** Недостаточно средств */
    final public const INSUFFICIENT_FUNDS = 5051;

    /** Карта просрочена или неверно указан срок действия */
    final public const EXPIRED_CARD = 5054;

    /** Ограничение на карте */
    final public const TRANSACTION_NOT_PERMITTED = 5057;

    /** Транзакция была отклонена банком по подозрению в мошенничестве */
    final public const SUSPECTED_FRAUD_DECLINE = 5059;

    /** Карта не предназначена для платежей */
    final public const RESTRICTED_CARD_2 = 5062;

    /** Карта заблокирована из-за нарушений безопасности */
    final public const SECURITY_VIOLATION = 5063;

    /** Превышен лимит операций по карте */
    final public const EXCEED_WITHDRAWAL_FREQUENCY = 5065;

    /** Неверный CVV-код */
    final public const INCORRECT_CVV = 5082;

    /** Эмитент недоступен */
    final public const TIMEOUT = 5091;

    /** Эмитент недоступен */
    final public const CANNOT_REACH_NETWORK = 5092;

    /** Ошибка банка-эквайера или сети */
    final public const SYSTEM_ERROR = 5096;

    /** Операция не может быть обработана по прочим причинам */
    final public const UNABLE_TO_PROCESS = 5204;

    /** 3-D Secure авторизация не пройдена */
    final public const AUTHENTICATION_FAILED = 5206;

    /** 3-D Secure авторизация недоступна */
    final public const AUTHENTICATION_UNAVAILABLE = 5207;

    /** Лимиты эквайера на проведение операций */
    final public const ANTI_FRAUD = 5300;
}
