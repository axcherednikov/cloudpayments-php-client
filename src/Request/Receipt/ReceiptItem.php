<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#items
 */
class ReceiptItem extends BaseRequest
{
    public function __construct(
        public string $label,
        public string $price,
        public string $quantity,
        public string $amount,
        public ?string $vat = null,
        public ?string $method = null,
        public ?string $object = null,
        public ?string $measurementUnit = null,
        public ?string $excise = null,
        public ?string $countryOriginCode = null,
        public ?string $customsDeclarationNumber = null,
        public ?string $agentSign = null,
        public ?ReceiptItemAgentData $agentData = null,
        public ?ReceiptItemPurveyorData $purveyorData = null,
        public ?ReceiptItemProductCodeData $productCodeData = null,
        public ?string $additionalPositionInfo = null,
    ) {
    }
}
