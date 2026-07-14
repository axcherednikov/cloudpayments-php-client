<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * Операционный реквизит чека, тег ОФД 1270.
 *
 * @see https://developers.cloudkassir.ru/#operationreceiptrequisite
 */
final class OperationReceiptRequisite extends BaseRequest
{
    public function __construct(
        public int $operationIdentifier,
        public string $operationDate,
        public string $operationData,
    ) {
    }
}
