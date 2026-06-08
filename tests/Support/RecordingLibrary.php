<?php

declare(strict_types=1);

namespace Excent\Cloudpayments\Tests\Support;

use Excent\Cloudpayments\Library;
use Psr\Http\Message\ResponseInterface;

final class RecordingLibrary extends Library
{
    public ?string $lastMethod = null;

    /** @var array<string, mixed>|null */
    public ?array $lastPostData = null;

    private ResponseInterface $nextResponse;

    public function setNextResponse(ResponseInterface $nextResponse): void
    {
        $this->nextResponse = $nextResponse;
    }

    /**
     * @param array<string, mixed> $postData
     */
    public function sendRequest(string $method, array $postData = []): ResponseInterface
    {
        $this->lastMethod = $method;
        $this->lastPostData = $postData;

        return $this->nextResponse;
    }
}
