<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Enum;

enum TransactionStatus: string
{
    case AUTHORIZED = 'Authorized';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';
    case DECLINED = 'Declined';
}
