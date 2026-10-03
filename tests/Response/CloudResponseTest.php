<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Exceptions\ResponseFormatException;
use Excent\Cloudpayments\Response\AppleSessionResponse;
use Excent\Cloudpayments\Response\CloudResponse;
use Excent\Cloudpayments\Response\KktReceiptResponse;
use Excent\Cloudpayments\Response\Models\BaseModel;
use Excent\Cloudpayments\Response\Models\TransactionModel;
use Excent\Cloudpayments\Response\NotificationResponse;
use Excent\Cloudpayments\Response\OrderResponse;
use Excent\Cloudpayments\Response\QrLinkResponse;
use Excent\Cloudpayments\Response\SubscriptionArrayResponse;
use Excent\Cloudpayments\Response\SubscriptionResponse;
use Excent\Cloudpayments\Response\TokenArrayResponse;
use Excent\Cloudpayments\Response\TransactionResponse;
use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class CloudResponseTest extends TestCase
{
    /**
     * @dataProvider nullableModelResponsesProvider
     *
     * @param class-string<CloudResponse> $responseClass
     */
    public function testResponseModelDefaultsToNull(string $responseClass): void
    {
        $response = new $responseClass();

        $this->assertNull($response->model);
    }

    /**
     * @return array<string, array{class-string<CloudResponse>}>
     */
    public static function nullableModelResponsesProvider(): array
    {
        return [
            'generic' => [CloudResponse::class],
            'Apple Pay' => [AppleSessionResponse::class],
            'receipt' => [KktReceiptResponse::class],
            'notification' => [NotificationResponse::class],
            'order' => [OrderResponse::class],
            'QR link' => [QrLinkResponse::class],
            'subscription list' => [SubscriptionArrayResponse::class],
            'subscription' => [SubscriptionResponse::class],
            'token list' => [TokenArrayResponse::class],
            'transaction' => [TransactionResponse::class],
            '3DS transaction' => [TransactionWith3dsResponse::class],
        ];
    }

    public function testFillByResponseUsesDefaultsForNonObjectJson(): void
    {
        $response = new CloudResponse();
        $response->fillByResponse(new Response(200, [], '[]'));

        $this->assertFalse($response->success);
        $this->assertSame('Message is not set', $response->message);
        $this->assertSame('Warning is not set', $response->warning);
        $this->assertNull($response->errorCode);
    }

    public function testFillByResponseKeepsEmptyGenericModelBehavior(): void
    {
        $response = new CloudResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":true,"Model":{}}'));

        $this->assertInstanceOf(BaseModel::class, $response->model);
    }

    public function testFillByResponseKeepsLegacyGenericFalsyModelBehavior(): void
    {
        foreach ([false, 0, '', '0', []] as $model) {
            $json = json_encode(['Success' => true, 'Model' => $model], JSON_THROW_ON_ERROR);
            $response = new CloudResponse();
            $response->fillByResponse(new Response(200, [], $json));

            $this->assertNull(get_object_vars($response)['model']);
        }
    }

    public function testFillByResponseMapsIntegerErrorCode(): void
    {
        $response = new CloudResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":true,"ErrorCode":42}'));

        $this->assertTrue($response->success);
        $this->assertSame(42, $response->errorCode);
    }

    public function testFillByResponseKeepsNullForMissingAndNullErrorCode(): void
    {
        $missingErrorCode = new CloudResponse();
        $missingErrorCode->fillByResponse(new Response(200, [], '{"Success":true}'));

        $nullErrorCode = new CloudResponse();
        $nullErrorCode->fillByResponse(new Response(200, [], '{"Success":true,"ErrorCode":null}'));

        $this->assertNull($missingErrorCode->errorCode);
        $this->assertNull($nullErrorCode->errorCode);
    }

    public function testTransactionResponseHydratesLargeRawJsonIntegerExactly(): void
    {
        $response = new TransactionResponse();
        $response->fillByResponse(new Response(200, [], '{"Success":false,"Model":{"TransactionId":9007199254740993}}'));

        $this->assertInstanceOf(TransactionModel::class, $response->model);
        $this->assertSame(9007199254740993, $response->model->transactionId);
    }

    public function testTransactionResponseRejectsMissingModelTransactionId(): void
    {
        $this->expectException(ResponseFormatException::class);
        (new TransactionResponse())->fillByResponse(new Response(200, [], '{"Success":false,"Model":{}}'));
    }

    /**
     * @dataProvider falsySuppliedModelsProvider
     */
    public function testTransactionResponseRejectsFalsySuppliedModels(mixed $model): void
    {
        $json = json_encode(['Success' => false, 'Model' => $model], JSON_THROW_ON_ERROR);
        $this->expectException(ResponseFormatException::class);

        (new TransactionResponse())->fillByResponse(new Response(200, [], $json));
    }

    /**
     * @return array<string, array{0: mixed}>
     */
    public static function falsySuppliedModelsProvider(): array
    {
        return [
            'false' => [false],
            'zero' => [0],
            'empty string' => [''],
            'zero string' => ['0'],
            'empty array' => [[]],
        ];
    }

    public function testTransactionResponseAcceptsNativeIntegerBoundsFromRawJson(): void
    {
        $response = new TransactionResponse();
        $json = '{"Success":true,"Model":{"TransactionId":' . PHP_INT_MAX . '}}';
        $response->fillByResponse(new Response(200, [], $json));
        $this->assertInstanceOf(TransactionModel::class, $response->model);
        $this->assertSame(PHP_INT_MAX, $response->model->transactionId);

        $response = new TransactionResponse();
        $json = '{"Success":true,"Model":{"TransactionId":' . PHP_INT_MIN . '}}';
        $response->fillByResponse(new Response(200, [], $json));
        $this->assertInstanceOf(TransactionModel::class, $response->model);
        $this->assertSame(PHP_INT_MIN, $response->model->transactionId);
    }

    /**
     * @dataProvider overflowingRawJsonIntegersProvider
     */
    public function testTransactionResponseRejectsOverflowingRawJsonIntegers(string $id): void
    {
        $this->expectException(ResponseFormatException::class);

        (new TransactionResponse())->fillByResponse(new Response(200, [], '{"Success":true,"Model":{"TransactionId":' . $id . '}}'));
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function overflowingRawJsonIntegersProvider(): array
    {
        return [
            'above maximum' => ['9223372036854775808'],
            'below minimum' => ['-9223372036854775809'],
            'very large integer' => ['999999999999999999999999999999999999999999999999999999999999'],
        ];
    }

    public function testTransactionResponsesAllowAbsentModelForSuccessAndFailure(): void
    {
        foreach (['{"Success":true}', '{"Success":false,"Message":"not found"}'] as $json) {
            $response = new TransactionResponse();
            $response->fillByResponse(new Response(200, [], $json));
            $this->assertNull(get_object_vars($response)['model']);
        }
    }

    public function testFillByResponseUsesDefaultsForInvalidScalarTypes(): void
    {
        $response = new CloudResponse();
        $response->fillByResponse(new Response(200, [], <<<'JSON'
            {"Success":1,"Message":false,"Warning":[],"ErrorCode":"17"}
            JSON));

        $this->assertFalse($response->success);
        $this->assertSame('Message is not set', $response->message);
        $this->assertSame('Warning is not set', $response->warning);
        $this->assertNull($response->errorCode);
    }

    public function testFillModelKeepsScalar(): void
    {
        $response = new CloudResponse();
        $response->fillModel('plain-model');

        $this->assertSame('plain-model', $response->model);
    }

    public function testFillModelConvertsObjectToBaseModel(): void
    {
        $response = new CloudResponse();
        $response->fillModel((object) ['UnknownField' => 'value']);

        $this->assertInstanceOf(BaseModel::class, $response->model);
        $this->assertSame('value', $response->model->getAdditionalProperties()['unknownField']);
    }
}
