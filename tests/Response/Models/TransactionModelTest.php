<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response\Models;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use PHPUnit\Framework\TestCase;
use stdClass;

final class TransactionModelTest extends TestCase
{
    public function testFillAssignsAdditionalTransactionFields(): void
    {
        $transaction = new TransactionModel((object) ['TransactionId' => 0]);
        $receiver = (object) ['inn' => '1234567890'];
        $splits = [
            (object) ['amount' => 10.50],
        ];
        $infoShopData = (object) ['name' => 'Shop'];

        $transaction->fill((object) [
            'TrInitiatorCode' => 0,
            'WalletType' => 'ApplePay',
            'VatAboveTotalFee' => 1.25,
            'ProcessorAndPartnerFee' => 2,
            'VatWithinProcessorFee' => 0.25,
            'InfoShopData' => $infoShopData,
            'Receiver' => $receiver,
            'Splits' => $splits,
            'TransactionIsInProcess' => true,
        ]);

        $this->assertSame(0, $transaction->trInitiatorCode);
        $this->assertSame('ApplePay', $transaction->walletType);
        $this->assertSame(1.25, $transaction->vatAboveTotalFee);
        $this->assertSame(2.0, $transaction->processorAndPartnerFee);
        $this->assertSame(0.25, $transaction->vatWithinProcessorFee);
        $this->assertSame($infoShopData, $transaction->infoShopData);
        $this->assertSame($receiver, $transaction->receiver);
        $this->assertSame($splits, $transaction->splits);
        $this->assertTrue($transaction->transactionIsInProcess);
    }

    public function testGetClientErrorCode(): void
    {
        $model = new TransactionModel((object) ['TransactionId' => 1]);
        $model->reasonCode = 5005;

        $this->assertSame('cloudpayments_error_5005', $model->getClientErrorCode());
    }

    public function testNormalizesExactTransactionIds(): void
    {
        $this->assertSame(9007199254740993, (new TransactionModel((object) ['TransactionId' => '09007199254740993']))->transactionId);
        $this->assertSame(PHP_INT_MIN, (new TransactionModel((object) ['TransactionId' => (string) PHP_INT_MIN]))->transactionId);
        $this->assertSame(0, (new TransactionModel((object) ['TransactionId' => '+000']))->transactionId);
    }

    /**
     * @dataProvider invalidTransactionIdsProvider
     */
    public function testRejectsInvalidTransactionIds(mixed $id): void
    {
        $this->expectException(ResponseFormatException::class);

        new TransactionModel((object) ['TransactionId' => $id]);
    }

    /**
     * @return array<string, array{0: mixed}>
     */
    public static function invalidTransactionIdsProvider(): array
    {
        return [
            'null' => [null],
            'boolean' => [true],
            'float' => [1.0],
            'decimal string' => ['1.0'],
            'exponent string' => ['1e2'],
            'leading whitespace' => [' 1'],
            'empty string' => [''],
            'nonnumeric string' => ['abc'],
            'array' => [[]],
            'object' => [new stdClass()],
            'overflow' => ['999999999999999999999999999999999'],
        ];
    }

    public function testFillCannotReplaceTransactionIdWithInvalidValue(): void
    {
        $transaction = new TransactionModel((object) ['TransactionId' => 42]);
        $this->expectException(ResponseFormatException::class);
        $transaction->fill((object) ['transactionId' => true]);
    }

    public function testFillValidatesBothIdSpellingsAndPreservesIdOnPartialFill(): void
    {
        $transaction = new TransactionModel((object) ['TransactionId' => 42]);
        $transaction->fill((object) ['Description' => 'updated']);
        $this->assertSame(42, $transaction->transactionId);

        $this->expectException(ResponseFormatException::class);
        $transaction->fill((object) ['TransactionId' => true]);
    }
}
