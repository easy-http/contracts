<?php

namespace EasyHttp\Contracts\Tests\Unit\Example;

use EasyHttp\Contracts\Contracts\HttpClientResponse;

class ClientResponse implements HttpClientResponse
{
    protected array $headers;
    protected int $status;
    protected string $body;

    public function __construct(array $response)
    {
        $this->headers = $response['headers'];
        $this->status = $response['status'];
        $this->body = $response['body'];
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function parseJson(): array
    {
        return (array) json_decode($this->body) ?? [];
    }
}
