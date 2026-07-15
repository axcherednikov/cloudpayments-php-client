<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response\Models;

/**
 * Банк — участник СБП.
 */
class SbpBankMemberModel extends BaseModel
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $logo = null;
    public ?string $url = null;
}
