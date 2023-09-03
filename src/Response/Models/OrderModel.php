<?php

namespace Excent\Cloudpayments\Response\Models;

/**
 * Class OrderModel.
 */
class OrderModel extends BaseModel
{
    public ?string $id = null;
    public ?int $number = null;
    public ?float $amount = null;
    public ?string $currency = null;
    public ?int $currencyCode = null;
    public ?string $email = null;
    public ?string $description = null;
    public ?bool $requireConfirmation = null;
    public ?string $url = null;
}
