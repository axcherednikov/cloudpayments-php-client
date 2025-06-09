<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;

/**
 * Class KktReceipt.
 *
 * @see     https://developers.cloudkassir.ru/#formirovanie-kassovogo-cheka
 */
class KktReceipt extends BaseRequest
{
    public ?string $invoiceId = null;
    public ?string $accountId = null;

    /**
     * KktReceipt constructor.
     */
    public function __construct(public string $inn, public string $type, public CustomerReceipt $customerReceipt)
    {
    }
}
