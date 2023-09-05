<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class OrderCancel.
 *
 * @see     https://developers.cloudpayments.ru/#otmena-sozdannogo-scheta
 */
class OrderCancel extends BaseRequest
{
    public string $id;
}
