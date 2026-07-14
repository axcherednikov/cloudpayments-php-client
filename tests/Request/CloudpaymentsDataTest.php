<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Enum\RussiaTimeZone;
use Excent\Cloudpayments\Enum\Vat;
use Excent\Cloudpayments\Request\CloudpaymentsData;
use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;
use Excent\Cloudpayments\Request\Receipt\IndustryRequisiteCollection;
use Excent\Cloudpayments\Request\Receipt\NonCashPayments;
use Excent\Cloudpayments\Request\Receipt\OperationReceiptRequisite;
use Excent\Cloudpayments\Request\Receipt\ReceiptAmounts;
use Excent\Cloudpayments\Request\Receipt\ReceiptItem;
use Excent\Cloudpayments\Request\Receipt\UserRequisiteData;
use PHPUnit\Framework\TestCase;

final class CloudpaymentsDataTest extends TestCase
{
    public function testReceiptItemKeepsLegacyStringVat(): void
    {
        $item = new ReceiptItem('Item', '100.00', '1.00', '100.00', '20');

        $this->assertSame('20', $item->asArray()['Vat']);
    }

    public function testReceiptItemKeepsLegacyStringVatPropertyInChildClass(): void
    {
        $item = new LegacyReceiptItem('Item', '100.00', '1.00', '100.00', Vat::PERCENT_22);

        $this->assertSame('22', $item->vat);
    }

    public function testJsonDataConvertsOnlyValidVatIntegerStrings(): void
    {
        $data = new CloudpaymentsData(new CustomerReceipt([
            new ReceiptItem('Valid', '100.00', '1.00', '100.00', '22'),
            new ReceiptItem('Decimal', '100.00', '1.00', '100.00', '5.5'),
            new ReceiptItem('Exponent', '100.00', '1.00', '100.00', '2e1'),
            new ReceiptItem('Unknown', '100.00', '1.00', '100.00', '999'),
        ]));

        $items = $data->asArray()['cloudpayments']['CustomerReceipt']['Items'];

        $this->assertSame(22, $items[0]['Vat']);
        $this->assertSame('5.5', $items[1]['Vat']);
        $this->assertSame('2e1', $items[2]['Vat']);
        $this->assertSame('999', $items[3]['Vat']);
    }

    public function testWrapsCustomerReceiptAndAdditionalData(): void
    {
        $receipt = new CustomerReceipt(
            [new ReceiptItem('Item', '100.00', '1.00', '100.00', Vat::PERCENT_22)],
            '2',
            new ReceiptAmounts(electronic: '100.00'),
            isBso: false,
            customerBirthday: '1990-01-01',
            userRequisiteData: new UserRequisiteData('key', 'value'),
            operationReceiptRequisite: new OperationReceiptRequisite(
                123,
                '2026-07-15T12:00:00+03:00',
                'operation-data',
            ),
            industryRequisiteCollection: [
                new IndustryRequisiteCollection('code', '2026-07-15', 'document-1', 'value'),
            ],
            isInternetPayment: true,
            russiaTimeZone: RussiaTimeZone::RTZ_2,
            nonCashPayments: [new NonCashPayments(100.00, 1, 'payment-1', 'Additional info')],
        );
        $data = new CloudpaymentsData($receipt, ['name' => 'Customer']);

        $this->assertSame([
            'cloudpayments' => [
                'name' => 'Customer',
                'CustomerReceipt' => [
                    'Items' => [
                        [
                            'Vat' => 22,
                            'Label' => 'Item',
                            'Price' => '100.00',
                            'Quantity' => '1.00',
                            'Amount' => '100.00',
                        ],
                    ],
                    'TaxationSystem' => '2',
                    'Amounts' => ['Electronic' => '100.00'],
                    'IsBso' => false,
                    'CustomerBirthday' => '1990-01-01',
                    'UserRequisiteData' => [
                        'RequisiteKey' => 'key',
                        'RequisiteValue' => 'value',
                    ],
                    'OperationReceiptRequisite' => [
                        'OperationIdentifier' => 123,
                        'OperationDate' => '2026-07-15T12:00:00+03:00',
                        'OperationData' => 'operation-data',
                    ],
                    'IndustryRequisiteCollection' => [
                        [
                            'Code' => 'code',
                            'DocumentDate' => '2026-07-15',
                            'DocumentNumber' => 'document-1',
                            'RequisiteValue' => 'value',
                        ],
                    ],
                    'IsInternetPayment' => true,
                    'RussiaTimeZone' => 2,
                    'NonCashPayments' => [
                        [
                            'Amount' => 100.00,
                            'PaymentMethod' => 1,
                            'PaymentId' => 'payment-1',
                            'AdditionalInfo' => 'Additional info',
                        ],
                    ],
                ],
            ],
        ], $data->asArray());

        $this->assertJson($data->asJson());
    }
}

final class LegacyReceiptItem extends ReceiptItem
{
    public ?string $vat = null;
}
