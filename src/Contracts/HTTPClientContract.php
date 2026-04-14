<?php

namespace EasyHTTP\Contracts\Contracts;

use Psr\EventDispatcher\EventDispatcherInterface;

interface HTTPClientContract
{
    public function getRequest(): HTTPClientRequest;
    public function call(string $method, string $uri): HTTPClientResponse;
    public function prepareRequest(string $method, string $uri): HTTPClientRequest;
    public function withHandler(callable $handler): self;
    public function withEventDispatcher(EventDispatcherInterface $eventDispatcher): self;
    public function execute(): HTTPClientResponse;
    public function stream(): HTTPStreamResponse;
}
