<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

use DateTimeImmutable;
use DateTimeInterface;
use Excent\Cloudpayments\Enum\TimezoneCodes;
use Excent\Cloudpayments\Enum\TransactionStatus;
use Excent\Cloudpayments\Exceptions\BadTypeException;

final class PaymentsListV2 extends BaseRequest
{
    /**
     * @param list<TransactionStatus> $statuses
     *
     * @throws BadTypeException
     */
    public function __construct(
        public readonly DateTimeImmutable $createdDateGte,
        public readonly DateTimeImmutable $createdDateLte,
        public readonly int $pageNumber,
        public readonly ?TimezoneCodes $timeZone = null,
        public readonly array $statuses = [],
    ) {
        if ($pageNumber < 1) {
            throw new BadTypeException('Page number must be greater than or equal to 1');
        }
    }

    /**
     * @return array{
     *     CreatedDateGte: string,
     *     CreatedDateLte: string,
     *     PageNumber: int,
     *     TimeZone?: string,
     *     Statuses?: list<string>
     * }
     */
    public function asArray(): array
    {
        $data = [
            'CreatedDateGte' => $this->createdDateGte->format(DateTimeInterface::ATOM),
            'CreatedDateLte' => $this->createdDateLte->format(DateTimeInterface::ATOM),
            'PageNumber' => $this->pageNumber,
        ];

        if ($this->timeZone !== null) {
            $data['TimeZone'] = $this->timeZone->value;
        }

        if ($this->statuses !== []) {
            $data['Statuses'] = array_map(
                static fn (TransactionStatus $status): string => $status->value,
                $this->statuses,
            );
        }

        return $data;
    }
}
