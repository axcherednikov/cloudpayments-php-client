<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Коды временных зон
 * https://developers.cloudpayments.ru/#kody-vremennyh-zon.
 */
enum TimezoneCodes: string
{
    /**
     * (UTC-10:00) Гавайи.
     */
    case HST = 'HST';

    /**
     * (UTC-09:00) Аляска.
     */
    case AKST = 'AKST';

    /**
     * (UTC-08:00) Тихоокеанское время (США и Канада).
     */
    case PST = 'PST';

    /**
     * (UTC-07:00) Горное время (США и Канада).
     */
    case MST = 'MST';

    /**
     * (UTC-06:00) Центральное время (США и Канада).
     */
    case CST = 'CST';

    /**
     * (UTC-05:00) Восточное время (США и Канада).
     */
    case EST = 'EST';

    /**
     * (UTC-04:00) Атлантическое время (Канада).
     */
    case AST = 'AST';

    /**
     * (UTC-03:00) Бразилия.
     */
    case BRT = 'BRT';

    /**
     * (UTC) Время в формате UTC.
     */
    case UTC = 'UTC';

    /**
     * (UTC) Дублин, Лиссабон, Лондон, Эдинбург.
     */
    case GMT = 'GMT';

    /**
     * (UTC+01:00) Амстердам, Берлин, Берн, Вена, Рим, Стокгольм
     * (UTC+01:00) Белград, Братислава, Будапешт, Любляна, Прага
     * (UTC+01:00) Брюссель, Копенгаген, Мадрид, Париж
     * (UTC+01:00) Варшава, Загреб, Сараево, Скопье.
     */
    case CET = 'CET';

    /**
     * (UTC+02:00) Афины, Бухарест
     * (UTC+02:00) Вильнюс, Киев, Рига, София, Таллин, Хельсинки
     * (UTC+02:00) Восточная Европа
     * (UTC+02:00) Калининград (RTZ 1).
     */
    case EET = 'EET';

    /**
     * (UTC+03:00) Волгоград, Москва, Санкт-Петербург (RTZ 2)
     * (UTC+03:00) Минск.
     */
    case MSK = 'MSK';

    /**
     * (UTC+04:00) Баку.
     */
    case AZT = 'AZT';

    /**
     * (UTC+04:00) Ереван.
     */
    case AMT = 'AMT';

    /**
     * (UTC+04:00) Ижевск, Самара (RTZ 3).
     */
    case SAMT = 'SAMT';

    /**
     * (UTC+04:00) Тбилиси.
     */
    case GET = 'GET';

    /**
     * (UTC+05:00) Ашхабад, Ташкент
     */
    case TJT = 'TJT';

    /**
     * (UTC+05:00) Екатеринбург (RTZ 4).
     */
    case YEKT = 'YEKT';

    /**
     * (UTC+06:00) Астана, Алматы.
     */
    case ALMT = 'ALMT';

    /**
     * (UTC+06:00) Новосибирск (RTZ 5).
     */
    case NOVT = 'NOVT';

    /**
     * (UTC+07:00) Красноярск (RTZ 6).
     */
    case KRAT = 'KRAT';

    /**
     * (UTC+08:00) Гонконг, Пекин, Урумчи, Чунцин.
     */
    case HKT = 'HKT';

    /**
     * (UTC+08:00) Иркутск (RTZ 7).
     */
    case IRKT = 'IRKT';

    /**
     * (UTC+08:00) Куала-Лумпур, Сингапур
     */
    case SGT = 'SGT';

    /**
     * (UTC+08:00) Улан-Батор
     */
    case ULAT = 'ULAT';

    /**
     * (UTC+09:00) Якутск (RTZ 8).
     */
    case YAKT = 'YAKT';

    /**
     * (UTC+10:00) Владивосток, Магадан (RTZ 9).
     */
    case VLAT = 'VLAT';

    /**
     * (UTC+11:00) Чокурдах (RTZ 10).
     */
    case SAKT = 'SAKT';

    /**
     * (UTC+12:00) Анадырь, Петропавловск-Камчатский (RTZ 11).
     */
    case ANAT = 'ANAT';
}
