<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Response\Models;

use stdClass;

/**
 * Источник списка участников СБП.
 */
class SbpBanksInfoModel extends BaseModel
{
    public ?string $source = null;
    public ?string $version = null;

    /** @var SbpBankMemberModel[] */
    public array $members = [];

    public function fill(stdClass $fillData): void
    {
        $membersData = [];
        $data = clone $fillData;

        foreach (['Members', 'members'] as $key) {
            if (property_exists($data, $key)) {
                $membersData = $data->{$key};
                unset($data->{$key});

                break;
            }
        }

        parent::fill($data);

        $this->members = [];

        if (! is_array($membersData)) {
            return;
        }

        foreach ($membersData as $memberData) {
            if (! $memberData instanceof stdClass) {
                continue;
            }

            $member = new SbpBankMemberModel();
            $member->fill($memberData);
            $this->members[] = $member;
        }
    }
}
