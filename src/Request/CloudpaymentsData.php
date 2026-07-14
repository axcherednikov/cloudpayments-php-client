<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

use BackedEnum;
use Excent\Cloudpayments\Enum\Vat;
use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;
use Excent\Cloudpayments\Request\Receipt\ReceiptItem;
use JsonException;

/**
 * Данные для поля JsonData в формате CloudPayments.
 *
 * Оборачивает данные в объект cloudpayments и может использоваться
 * в любом платежном методе, поддерживающем JsonData.
 */
final class CloudpaymentsData extends BaseRequest
{
    /**
     * @param array<string, mixed> $additionalData
     */
    public function __construct(
        public ?CustomerReceipt $customerReceipt = null,
        public array $additionalData = [],
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function asArray(): array
    {
        $data = $this->serializeValue($this->additionalData);

        if ($this->customerReceipt !== null) {
            $data['CustomerReceipt'] = $this->serializeValue($this->customerReceipt);
        }

        return ['cloudpayments' => $data];
    }

    /**
     * @throws JsonException
     */
    public function asJson(): string
    {
        return json_encode($this->asArray(), JSON_THROW_ON_ERROR);
    }

    private function serializeValue(mixed $value): mixed
    {
        if ($value instanceof ReceiptItem) {
            $data = $this->serializeRequest($value);

            if ($value->vat !== null && preg_match('/^(0|[1-9]\d*)$/D', $value->vat) === 1) {
                $vat = Vat::tryFrom((int) $value->vat);

                if ($vat !== null) {
                    $data['Vat'] = $vat->value;
                }
            }

            return $data;
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof BaseRequest) {
            return $this->serializeRequest($value);
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->serializeValue($item);
            }
        }

        return $value;
    }

    /**
     * @return array<string, mixed>
     */
    private function serializeRequest(BaseRequest $request): array
    {
        $data = [];

        foreach (get_object_vars($request) as $field => $fieldValue) {
            if ($fieldValue === null) {
                continue;
            }

            $data[ucfirst((string) $field)] = $this->serializeValue($fieldValue);
        }

        return $data;
    }
}
