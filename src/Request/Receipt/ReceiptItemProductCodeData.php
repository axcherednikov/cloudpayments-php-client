<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Request\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#productcodedata
 */
class ReceiptItemProductCodeData extends BaseRequest
{
    public ?string $codeProductNomenclature = null;
}
