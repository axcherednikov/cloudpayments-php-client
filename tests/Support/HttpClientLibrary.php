<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Support;

use Excent\Cloudpayments\Library;
use GuzzleHttp\Client;

final class HttpClientLibrary extends Library
{
    public function replaceClient(Client $client): void
    {
        $this->client = $client;
    }
}
