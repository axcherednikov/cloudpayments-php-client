<?php

namespace Excent\Cloudpayments\Tests\Response\Models;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseModelTest.
 *
 * @group Cloudpayments
 */
class BaseModelTest extends TestCase
{
    /**
     * Проверяем заполнение модели по объекту.
     */
    public function testFillBaseModel(): void
    {
        $testObject = (object) ['a' => 1, 'b' => 2, 'c' => 3];

        $model = new TestModel();
        $model->fill($testObject);

        $this->assertEquals($testObject->a, $model->a);
        $this->assertEquals($testObject->b, $model->b);
        $this->assertEquals($testObject->c, $model->c);
    }

    /**
     * Проверяем, что неизвестные поля не становятся динамическими свойствами.
     */
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
