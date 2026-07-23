<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use DateTimeImmutable;
use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\ChargebacksList;
use PHPUnit\Framework\TestCase;

final class ChargebacksListTest extends TestCase
{
    public function testAsArraySerializesRequiredParameters(): void
    {
        $request = new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
        );

        $this->assertSame([
            'CreatedDateGte' => '2021-03-09T00:00:00+03:00',
            'CreatedDateLte' => '2021-03-10T00:00:00+03:00',
            'PageNumber' => 1,
        ], $request->asArray());
    }

    public function testAsArrayPreservesDateTimeOffsets(): void
    {
        $request = new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T01:30:00+04:00'),
            1,
        );

        $this->assertSame('2021-03-09T00:00:00+03:00', $request->asArray()['CreatedDateGte']);
        $this->assertSame('2021-03-10T01:30:00+04:00', $request->asArray()['CreatedDateLte']);
    }

    public function testRejectsPageNumberLessThanOne(): void
    {
        $this->expectException(BadTypeException::class);

        new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            0,
        );
    }

    public function testRejectsEndBeforeStart(): void
    {
        $this->expectException(BadTypeException::class);

        new ChargebacksList(
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            1,
        );
    }

    public function testRejectsPeriodLongerThanOneCalendarYear(): void
    {
        $this->expectException(BadTypeException::class);

        new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2022-03-09T00:00:01+03:00'),
            1,
        );
    }

    public function testAcceptsPeriodOfExactlyOneCalendarYear(): void
    {
        $request = new ChargebacksList(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2022-03-09T00:00:00+03:00'),
            1,
        );

        $this->assertSame('2022-03-09T00:00:00+03:00', $request->asArray()['CreatedDateLte']);
    }
}
