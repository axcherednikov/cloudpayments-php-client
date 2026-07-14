<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\Enum\RussiaTimeZone;
use Excent\Cloudpayments\Request\BaseRequest;

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
     * @param  array<int|string, mixed>|null $additionalReceiptInfos
     * @param  string|null          $additionalReceiptRequisite
     * @param  string|null          $customerBirthday
     * @param  string|null          $customerStateCode
     * @param  string|null          $customerDocType
     * @param  string|null          $customerDoc
     * @param  string|null          $customerPlace
     * @param  UserRequisiteData|null    $userRequisiteData
     * @param  OperationReceiptRequisite|null $operationReceiptRequisite
     * @param  array<int, IndustryRequisiteCollection>|null $industryRequisiteCollection
     * @param  bool|null             $isInternetPayment
     * @param  RussiaTimeZone|null   $russiaTimeZone
     * @param  array<int, NonCashPayments>|null $nonCashPayments
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
        public ?string $additionalReceiptRequisite = null,
        public ?string $customerBirthday = null,
        public ?string $customerStateCode = null,
        public ?string $customerDocType = null,
        public ?string $customerDoc = null,
        public ?string $customerPlace = null,
        public ?UserRequisiteData $userRequisiteData = null,
        public ?OperationReceiptRequisite $operationReceiptRequisite = null,
        /** @var array<int, IndustryRequisiteCollection>|null */
        public ?array $industryRequisiteCollection = null,
        public ?bool $isInternetPayment = null,
        public ?RussiaTimeZone $russiaTimeZone = null,
        /** @var array<int, NonCashPayments>|null */
        public ?array $nonCashPayments = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function asArray(): array
    {
        $data = parent::asArray();

        if ($this->userRequisiteData !== null) {
            $data['UserRequisiteData'] = $this->userRequisiteData->asArray();
        }

        if ($this->operationReceiptRequisite !== null) {
            $data['OperationReceiptRequisite'] = $this->operationReceiptRequisite->asArray();
        }

        if ($this->russiaTimeZone !== null) {
            $data['RussiaTimeZone'] = $this->russiaTimeZone->value;
        }

        return $data;
    }
}
