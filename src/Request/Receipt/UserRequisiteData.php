<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * Дополнительный реквизит пользователя, тег ОФД 1084.
 *
 * @see https://developers.cloudkassir.ru/#userrequisitedata
 */
final class UserRequisiteData extends BaseRequest
{
    public function __construct(
        public string $requisiteKey,
        public string $requisiteValue,
    ) {
    }
}
