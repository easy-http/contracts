<?php

namespace EasyHTTP\Contracts\Contracts;

interface HTTPClientContract
{
    public function getRequest(): HTTPClientRequest;
    public function call(string $method, string $uri): HTTPClientResponse;
    public function prepareRequest(string $method, string $uri): HTTPClientRequest;
    public function withHandler(callable $handler): self;
    public function execute(): HTTPClientResponse;
    public function stream(): HTTPStreamResponse;
}
