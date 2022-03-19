<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\BaseRequest;

/**
 * Class OrderCancel
 *
 * @package Excent\Cloudpayments\Request
 * @see     https://developers.cloudpayments.ru/#otmena-sozdannogo-scheta
 */
class OrderCancel extends BaseRequest
{
    public string $id;
}
