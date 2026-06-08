<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Request;

use Excent\Cloudpayments\Request\Post3DS;
use PHPUnit\Framework\TestCase;

/**
 * @group Cloudpayments
 */
final class Post3DSTest extends TestCase
{
    public function testAsArrayContainsTransactionIdAndPaRes(): void
    {
        $this->assertSame(['TransactionId' => 123, 'PaRes' => 'pares'], (new Post3DS(123, 'pares'))->asArray());
    }
}
