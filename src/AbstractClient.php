<?php

namespace EasyHTTP\Contracts;

use EasyHTTP\Contracts\Contracts\HTTPClientContract;
use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\Contracts\HTTPClientResponse;
use EasyHTTP\Contracts\Contracts\HTTPStreamResponse;

abstract class AbstractClient implements HTTPClientContract
{
    protected HTTPClientAdapter $adapter;
    protected HTTPClientRequest $request;
    protected HTTPClientFactory $factory;
    protected $handler;

    public function __construct(HTTPClientFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getRequest(): HTTPClientRequest
    {
        return $this->request;
    }

    public function call(string $method, string $uri): HTTPClientResponse
    {
        $request = $this->factory->createRequest($method, $uri);
        return $this->getAdapter()->request($request);
    }

    public function prepareRequest(string $method, string $uri): HTTPClientRequest
    {
        $this->request = $this->factory->createRequest($method, $uri);

        return $this->request;
    }

    public function withHandler(callable $handler): self
    {
        $this->flushAdapter();
        $this->handler = $handler;

        return $this;
    }

    public function execute(): HTTPClientResponse
    {
        return $this->getAdapter()->request($this->request);
    }

    public function stream(): HTTPStreamResponse
    {
        return $this->getAdapter()->stream($this->request);
    }

    protected function getAdapter(): HTTPClientAdapter
    {
        if ($this->hasAdapter()) {
            return $this->adapter;
        }

        $this->adapter = $this->factory->createAdapter($this->handler);

        return $this->adapter;
    }

    protected function hasAdapter(): bool
    {
        return (bool) ($this->adapter ?? null);
    }

    protected function hasHandler(): bool
    {
        return (bool) ($this->handler ?? null);
    }

    protected function flushAdapter(): void
    {
        unset($this->adapter);
    }
}
