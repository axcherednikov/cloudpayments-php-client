<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#purveyordata
 */
class ReceiptItemPurveyorData extends BaseRequest
{
    public function __construct(
        public string $name,
        public string $inn,
        public ?string $phone = null,
    ) {
    }
}
