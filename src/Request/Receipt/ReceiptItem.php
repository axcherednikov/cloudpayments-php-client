<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Enum\Vat;
use Excent\Cloudpayments\Request\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#items
 */
class ReceiptItem extends BaseRequest
{
    public ?string $vat = null;

    public function __construct(
        public string $label,
        public string|float|int $price,
        public string|float|int $quantity,
        public string|float|int $amount,
        string|Vat|null $vat = null,
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
        $this->vat = $vat instanceof Vat ? (string) $vat->value : $vat;
    }
}
