<?php

namespace Excent\Cloudpayments\Response\Models;

/**
 * Class TransactionWith3dsModel
 *
 * @package Excent\Cloudpayments\Response\Models
 */
class TransactionWith3dsModel extends TransactionModel
{
    public ?string $paReq = null;
    public ?string $acsUrl = null;
}
