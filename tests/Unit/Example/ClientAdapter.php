<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\Contracts\HTTPClientResponse;
use EasyHTTP\Contracts\Contracts\HTTPStreamResponse;

class ClientAdapter implements HTTPClientAdapter
{
    protected $handler;

    public function setHandler(callable $handler): void
    {
        $this->handler = $handler;
    }

    public function request(HTTPClientRequest $request): HTTPClientResponse
    {
        $response = $this->call($request->getMethod(), $request->getUri());
        return new ClientResponse($response);
    }

    public function stream(HTTPClientRequest $request): HTTPStreamResponse
    {
        $response = $this->call($request->getMethod(), $request->getUri());
        return new StreamResponse($response);
    }

    private function call(string $method, string $uri): array
    {
        if ($this->handler) {
            return call_user_func($this->handler);
        }

        return [
            'status' => 200,
            'headers' => [
                'Server' => 'Apache/2.4.38 (Debian)',
                'X-Info' => $method . ' ' . $uri
            ],
            'body' => '{"key":"value"}',
        ];
    }
}
