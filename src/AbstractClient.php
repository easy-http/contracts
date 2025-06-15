<?php

namespace EasyHttp\Contracts;

use EasyHttp\Contracts\Contracts\EasyClientContract;
use EasyHttp\Contracts\Contracts\HttpClientAdapter;
use EasyHttp\Contracts\Contracts\HttpClientRequest;
use EasyHttp\Contracts\Contracts\HttpClientResponse;

abstract class AbstractClient implements EasyClientContract
{
    protected HttpClientAdapter $adapter;

    protected HttpClientRequest $request;

    protected $handler;

    public function getRequest(): HttpClientRequest
    {
        return $this->request;
    }

    public function call(string $method, string $uri): HttpClientResponse
    {
        $request = $this->buildRequest($method, $uri);
        return $this->getAdapter()->request($request);
    }

    public function prepareRequest(string $method, string $uri): HttpClientRequest
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

    public function execute(): HttpClientResponse
    {
        return $this->getAdapter()->request($this->request);
    }

    protected function getAdapter(): HttpClientAdapter
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

    abstract protected function buildRequest(string $method, string $uri): HttpClientRequest;
    abstract protected function buildAdapter(): HttpClientAdapter;
}
