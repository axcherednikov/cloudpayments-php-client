<?php

namespace Excent\Cloudpayments\Response\Models;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use stdClass;

/**
 * Class TransactionModel.
 */
class TransactionModel extends BaseModel
{
    public int $transactionId;
    public ?string $publicId = null;
    public ?string $terminalUrl = null;
    public ?float $amount = null;
    public ?string $currency = null;
    public ?int $currencyCode = null;
    public ?float $paymentAmount = null;
    public ?string $paymentCurrency = null;
    public ?int $paymentCurrencyCode = null;
    public ?string $invoiceId = null;
    public ?string $accountId = null;
    public ?int $trInitiatorCode = null;
    public ?string $email = null;
    public ?string $description = null;
    public ?string $jsonData = null;
    public ?string $createdDate = null;
    public ?string $createdDateIso = null;
    public ?string $payoutDate = null;
    public ?string $payoutDateIso = null;
    public ?int $payoutAmount = null;
    public ?string $authDate = null;
    public ?string $authDateIso = null;
    public ?string $confirmDate = null;
    public ?string $confirmDateIso = null;
    public ?string $authCode = null;
    public ?bool $testMode = null;
    public ?string $rrn = null;
    public ?int $originalTransactionId = null;
    public ?int $fallBackScenarioDeclinedTransactionId = null;
    public ?string $ipAddress = null;
    public ?string $ipCountry = null;
    public ?string $ipCity = null;
    public ?string $ipRegion = null;
    public ?string $ipDistrict = null;
    public ?string $ipLatitude = null;
    public ?string $ipLongitude = null;
    public ?string $cardFirstSix = null;
    public string $cardLastFour = '0000';
    public ?string $cardExpDate = null;
    public string $cardType = 'unknown';
    public ?int $cardTypeCode = null;
    public ?string $cardProduct = null;
    public ?string $cardCategory = null;
    public ?string $issuer = null;
    public ?string $issuerBankCountry = null;
    public ?string $status = null;
    public ?int $statusCode = null;
    public ?string $cultureName = null;
    public ?string $reason = null;
    public ?int $reasonCode = null;
    public ?string $cardHolderMessage = null;
    public ?int $type = null;
    public ?bool $refunded = null;
    public ?string $name = null;
    public ?int $subscriptionId = null;
    public ?bool $isLocalOrder = null;
    public ?bool $hideInvoiceId = null;
    public ?string $token = null;
    public ?int $gateway = null;
    public ?string $gatewayName = null;
    public ?bool $applePay = null;
    public ?bool $androidPay = null;
    public ?bool $masterPass = null;
    public ?string $walletType = null;
    public ?float $totalFee = null;
    public ?float $vatAboveTotalFee = null;
    public ?float $processorAndPartnerFee = null;
    public ?float $vatWithinProcessorFee = null;
    public mixed $infoShopData = null;
    public mixed $receiver = null;
    public mixed $splits = null;
    public ?bool $transactionIsInProcess = null;
    public ?int $escrowAccumulationId = null;

    public function __construct(stdClass $data)
    {
        $this->fill($data);
    }

    public function fill(stdClass $fillData): void
    {
        $props = get_object_vars($fillData);
        $hasId = false;

        foreach (['TransactionId', 'transactionId'] as $idKey) {
            if (array_key_exists($idKey, $props)) {
                $props[$idKey] = self::normalizeTransactionId($props[$idKey]);
                $hasId = true;
            }
        }

        if (! $hasId) {
            if (! isset($this->transactionId)) {
                throw new ResponseFormatException('TransactionId is required in a transaction model.');
            }
        }

        $normalized = new stdClass();

        foreach ($props as $key => $value) {
            $normalized->{$key} = $value;
        }
        parent::fill($normalized);
    }

    /**
     * @param  mixed  $value
     *
     * @throws ResponseFormatException
     */
    private static function normalizeTransactionId($value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (! is_string($value) || preg_match('/^[+-]?[0-9]+$/D', $value) !== 1) {
            throw new ResponseFormatException('TransactionId must be an integer or signed decimal integer string.');
        }

        $digits = ltrim(ltrim($value, '+-'), '0') === ''
            ? '0'
            : ltrim(ltrim($value, '+-'), '0');

        $limit = str_starts_with($value, '-') ? substr((string) PHP_INT_MIN, 1) : (string) PHP_INT_MAX;

        if (strlen($digits) > strlen($limit) || (strlen($digits) === strlen($limit) && strcmp($digits, $limit) > 0)) {
            throw new ResponseFormatException('TransactionId is outside the native integer range.');
        }

        return (int) ((str_starts_with($value, '-') && $digits !== '0' ? '-' : '') . $digits);
    }

    /**
     * Получение переведенного кода ошибки.
     *
     * @return string
     */
    public function getClientErrorCode(): string
    {
        return 'cloudpayments_error_' . $this->reasonCode;
    }
}
