<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\CloudResponse;
use Excent\Cloudpayments\Response\Models\BaseModel;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class CloudResponseTest extends TestCase
{
    public function testFillByResponseUsesDefaultsForNonObjectJson(): void
    {
        $response = new CloudResponse();
        $response->fillByResponse(new Response(200, [], '[]'));

        $this->assertFalse($response->success);
        $this->assertSame('Message is not set', $response->message);
        $this->assertSame('Warning is not set', $response->warning);
        $this->assertNull($response->errorCode);
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
