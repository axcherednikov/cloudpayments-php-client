<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Enum\SbpPlatform;

/**
 * Параметры получения списка участников СБП.
 *
 * @see https://developers.cloudpayments.ru/#spisok-uchastnikov-sbp
 */
final class SbpBanksInfo extends BaseRequest
{
    public function __construct(
        public ?string $accountId = null,
        public ?bool $isRenewSubscription = null,
        public ?string $jsonData = null,
        public ?SbpPlatform $platform = null,
        public ?bool $saveCard = null,
        public ?string $token = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function asArray(): array
    {
        $data = parent::asArray();

        if ($this->platform !== null) {
            $data['Platform'] = $this->platform->value;
        }

        return $data;
    }
}
