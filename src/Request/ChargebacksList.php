<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Request;

use DateTimeImmutable;
use DateTimeInterface;
use Excent\Cloudpayments\Exceptions\BadTypeException;

final class ChargebacksList extends BaseRequest
{
    /**
     * @throws BadTypeException
     */
    public function __construct(
        public readonly DateTimeImmutable $createdDateGte,
        public readonly DateTimeImmutable $createdDateLte,
        public readonly int $pageNumber,
    ) {
        if ($pageNumber < 1) {
            throw new BadTypeException('Page number must be greater than or equal to 1');
        }

        if ($createdDateLte < $createdDateGte) {
            throw new BadTypeException('CreatedDateLte must be greater than or equal to CreatedDateGte');
        }

        if ($createdDateLte > $createdDateGte->modify('+1 year')) {
            throw new BadTypeException('Chargebacks list period must not exceed one calendar year');
        }
    }

    /**
     * @return array{
     *     CreatedDateGte: string,
     *     CreatedDateLte: string,
     *     PageNumber: int
     * }
     */
    public function asArray(): array
    {
        return [
            'CreatedDateGte' => $this->createdDateGte->format(DateTimeInterface::ATOM),
            'CreatedDateLte' => $this->createdDateLte->format(DateTimeInterface::ATOM),
            'PageNumber' => $this->pageNumber,
        ];
    }
}
