<?php

namespace Excent\Cloudpayments\Enum;

use MyCLabs\Enum\Enum;

/**
 * Варианты систем налогообложения
 * https://developers.cloudkassir.ru/#taxationsystem.
 *
 * @see Enum
 */
class TaxationSystem extends Enum
{
    /**
     * Общая система налогообложения.
     *
     * @var int
     */
    final public const OSNO = 0;

    /**
     * Упрощенная система налогообложения (Доход).
     *
     * @var int
     */
    final public const USN_1 = 1;

    /**
     * Упрощенная система налогообложения (Доход минус Расход).
     *
     * @var int
     */
    final public const USN_2 = 2;

    /**
     * Единый налог на вмененный доход.
     *
     * @var int
     */
    final public const ENVD = 3;

    /**
     * Единый сельскохозяйственный налог.
     *
     * @var int
     */
    final public const ESN = 4;

    /**
     * Патентная система налогообложения.
     *
     * @var int
     */
    final public const PATENT = 5;
}
