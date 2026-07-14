<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * Отраслевой реквизит чека, тег ОФД 1261.
 *
 * @see https://developers.cloudkassir.ru/#industryrequisitecollection
 */
final class IndustryRequisiteCollection extends BaseRequest
{
    public function __construct(
        public string $code,
        public string $documentDate,
        public string $documentNumber,
        public string $requisiteValue,
    ) {
    }
}
