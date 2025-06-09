<?php

namespace Excent\Cloudpayments\Response\Models;

/**
 * Class TransactionWith3dsModel.
 */
class TransactionWith3dsModel extends TransactionModel
{
    public ?string $paReq = null;
    public ?string $acsUrl = null;
}
