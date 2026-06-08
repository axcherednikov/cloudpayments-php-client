<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response\Models;

use PHPUnit\Framework\TestCase;

final class BaseModelTest extends TestCase
{
    public function testFillAssignsKnownProperties(): void
    {
        $testObject = (object) ['a' => 1, 'b' => 2, 'c' => 3];

        $model = new TestModel();
        $model->fill($testObject);

        $this->assertEquals($testObject->a, $model->a);
        $this->assertEquals($testObject->b, $model->b);
        $this->assertEquals($testObject->c, $model->c);
    }

    public function testFillKeepsUnknownFieldsWithoutDynamicProperties(): void
    {
        $model = new TestModel();

        $model->fill((object) [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'UnknownField' => 'value',
        ]);

        $this->assertSame('value', $model->getAdditionalProperties()['unknownField']);
        $this->assertArrayNotHasKey('unknownField', get_object_vars($model));
    }
}
