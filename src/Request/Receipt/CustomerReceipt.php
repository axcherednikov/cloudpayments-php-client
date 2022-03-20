<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#customerreceipt
 */
class CustomerReceipt extends BaseRequest
{
    /**
     * @param  ReceiptItem[]        $items
     * @param  string|null          $taxationSystem
     * @param  ReceiptAmounts|null  $amounts
     * @param  string|null          $calculationPlace
     * @param  string|null          $email
     * @param  string|null          $phone
     * @param  string|null          $customerInfo
     * @param  string|null          $customerInn
     * @param  bool|null            $isBso
     * @param  string|null          $agentSign
     * @param  string|null          $cashierName
     * @param  array|null           $additionalReceiptInfos
     */
    public function __construct(
        public array $items,
        public ?string $taxationSystem = null,
        public ?ReceiptAmounts $amounts = null,
        public ?string $calculationPlace = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $customerInfo = null,
        public ?string $customerInn = null,
        public ?bool $isBso = null,
        public ?string $agentSign = null,
        public ?string $cashierName = null,
        public ?array $additionalReceiptInfos = null,
    ) {
    }
}
