<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Response;

use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use PHPUnit\Framework\TestCase;

final class TransactionWith3dsModelTest extends TestCase
{
    public function testIs3dsErrorReturnsTrueWhenPaReqAndAcsUrlAreFilled(): void
    {
        $responseModel = (object) ['PaReq' => 'some', 'AcsUrl' => 'some'];

        $cloudResponseModel = new TransactionWith3dsResponse();
        $cloudResponseModel->fillModel($responseModel);

        $this->assertTrue($cloudResponseModel->is3dsError());
    }

    public function testIs3dsErrorReturnsFalseWhenPaReqAndAcsUrlAreMissing(): void
    {
        $responseModel = (object) [];

        $cloudResponseModel = new TransactionWith3dsResponse();
        $cloudResponseModel->fillModel($responseModel);

        $this->assertFalse($cloudResponseModel->is3dsError());
    }
}
