<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use DateTimeImmutable;
use Excent\Cloudpayments\Enum\TimezoneCodes;
use Excent\Cloudpayments\Enum\TransactionStatus;
use Excent\Cloudpayments\Exceptions\BadTypeException;
use Excent\Cloudpayments\Request\PaymentsListV2;
use PHPUnit\Framework\TestCase;

final class PaymentsListV2Test extends TestCase
{
    public function testAsArraySerializesRequiredParameters(): void
    {
        $request = new PaymentsListV2(
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

    public function testAsArraySerializesAllParameters(): void
    {
        $request = new PaymentsListV2(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
            TimezoneCodes::MSK,
            [
                TransactionStatus::AUTHORIZED,
                TransactionStatus::COMPLETED,
                TransactionStatus::CANCELLED,
                TransactionStatus::DECLINED,
            ],
        );

        $this->assertSame([
            'CreatedDateGte' => '2021-03-09T00:00:00+03:00',
            'CreatedDateLte' => '2021-03-10T00:00:00+03:00',
            'PageNumber' => 1,
            'TimeZone' => 'MSK',
            'Statuses' => ['Authorized', 'Completed', 'Cancelled', 'Declined'],
        ], $request->asArray());
    }

    public function testAsArrayOmitsEmptyStatuses(): void
    {
        $request = new PaymentsListV2(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            1,
            statuses: [],
        );

        $this->assertArrayNotHasKey('Statuses', $request->asArray());
    }

    public function testRejectsPageNumberLessThanOne(): void
    {
        $this->expectException(BadTypeException::class);

        new PaymentsListV2(
            new DateTimeImmutable('2021-03-09T00:00:00+03:00'),
            new DateTimeImmutable('2021-03-10T00:00:00+03:00'),
            0,
        );
    }
}
