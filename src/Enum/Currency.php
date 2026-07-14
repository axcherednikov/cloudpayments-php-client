<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Валюты CloudPayments.
 */
enum Currency: string
{
    case RUB = 'RUB';
    case EUR = 'EUR';
    case USD = 'USD';
    case GBP = 'GBP';
    case UAH = 'UAH';
    case BYR = 'BYR';
    case BYN = 'BYN';
    case KZT = 'KZT';
    case AZN = 'AZN';
    case CHF = 'CHF';
    case CZK = 'CZK';
    case CAD = 'CAD';
    case PLN = 'PLN';
    case SEK = 'SEK';
    case TRY = 'TRY';
    case CNY = 'CNY';
    case INR = 'INR';
    case BRL = 'BRL';
    case ZAR = 'ZAR';
    case UZS = 'UZS';
    case BGN = 'BGN';
    case RON = 'RON';
    case AUD = 'AUD';
    case HKD = 'HKD';
    case GEL = 'GEL';
    case KGS = 'KGS';
    case AMD = 'AMD';
    case AED = 'AED';
}
