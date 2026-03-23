<?php

namespace EasyHTTP\Contracts;

use EasyHTTP\Contracts\Contracts\HTTPClientContract;
use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\Contracts\HTTPClientResponse;

abstract class AbstractClient implements HTTPClientContract
{
    protected HTTPClientAdapter $adapter;

    protected HTTPClientRequest $request;

    protected $handler;

    public function getRequest(): HTTPClientRequest
    {
        return $this->request;
    }

    public function call(string $method, string $uri): HTTPClientResponse
    {
        $request = $this->buildRequest($method, $uri);
        return $this->getAdapter()->request($request);
    }

    public function prepareRequest(string $method, string $uri): HTTPClientRequest
    {
        $this->request = $this->buildRequest($method, $uri);

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

    protected function getAdapter(): HTTPClientAdapter
    {
        if ($this->hasAdapter()) {
            return $this->adapter;
        }

        $this->adapter = $this->buildAdapter();

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

    abstract protected function buildRequest(string $method, string $uri): HTTPClientRequest;
    abstract protected function buildAdapter(): HTTPClientAdapter;
}
