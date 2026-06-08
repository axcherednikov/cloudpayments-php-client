<?php

namespace Excent\Cloudpayments\Tests\Response\Models;

use Excent\Cloudpayments\Response\Models\TransactionModel;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionModelTest.
 *
 * @group Cloudpayments
 */
class TransactionModelTest extends TestCase
{
    /**
     * Проверяем заполнение полей транзакции, которые возвращает CloudPayments.
     */
    public function testFillAdditionalTransactionFields(): void
    {
        $transaction = new TransactionModel();
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
}
