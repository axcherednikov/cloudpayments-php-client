<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;
use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;

/**
 * Class KktReceipt
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudkassir.ru/#formirovanie-kassovogo-cheka
 */
class KktReceipt extends BaseRequest
{
    public string $inn;
    public string $type;
    public CustomerReceipt $customerReceipt;
    public ?string $invoiceId = null;
    public ?string $accountId = null;

    /**
     * KktReceipt constructor.
     *
     * @param  string           $inn
     * @param  string           $type
     * @param  CustomerReceipt  $customerReceipt
     */
    public function __construct(string $inn, string $type, CustomerReceipt $customerReceipt)
    {
        $this->inn = $inn;
        $this->type = $type;
        $this->customerReceipt = $customerReceipt;
    }
}
