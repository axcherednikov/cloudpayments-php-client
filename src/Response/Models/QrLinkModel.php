<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response\Models;

/**
 * Модель ответа на создание ссылки для оплаты через СБП.
 */
class QrLinkModel extends BaseModel
{
    public ?string $qrUrl = null;
    public ?string $qrImage = null;
    public ?int $transactionId = null;
    public ?string $merchantOrderId = null;
    public ?string $providerQrId = null;
    public int|float|null $amount = null;
    public ?string $message = null;
    public ?bool $isTest = null;
}
