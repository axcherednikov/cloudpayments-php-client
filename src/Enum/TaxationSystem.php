<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

/**
 * Варианты систем налогообложения
 * https://developers.cloudkassir.ru/#taxationsystem.
 */
enum TaxationSystem: int
{
    /**
     * Общая система налогообложения.
     */
    case OSNO = 0;

    /**
     * Упрощенная система налогообложения (Доход).
     */
    case USN_1 = 1;

    /**
     * Упрощенная система налогообложения (Доход минус Расход).
     */
    case USN_2 = 2;

    /**
     * Единый налог на вмененный доход.
     */
    case ENVD = 3;

    /**
     * Единый сельскохозяйственный налог.
     */
    case ESN = 4;

    /**
     * Патентная система налогообложения.
     */
    case PATENT = 5;
}
