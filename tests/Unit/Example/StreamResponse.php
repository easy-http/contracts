<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use EasyHTTP\Contracts\Contracts\HTTPStreamResponse;
use Generator;

class StreamResponse implements HTTPStreamResponse
{
    protected array $headers;
    protected int $status;
    protected Generator $body;

    public function __construct(array $response)
    {
        $this->headers = $response['headers'];
        $this->status = $response['status'];

        $body = $response['body'];
        $generator = function () use ($body): Generator {
            // breakdown the body by spaces into chunks
            $chunks = explode(' ', $body);
            foreach ($chunks as $chunk) {
                yield $chunk;
            }
        };

        $this->body = $generator();
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): Generator
    {
        return $this->body;
    }
}
