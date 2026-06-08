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
