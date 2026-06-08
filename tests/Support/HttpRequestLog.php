<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Support;

final class HttpRequestLog
{
    public string $method = '';

    public string $path = '';

    /** @var array<string, string[]> */
    public array $headers = [];

    /** @var array<int|string, mixed> */
    public array $formParams = [];
}
