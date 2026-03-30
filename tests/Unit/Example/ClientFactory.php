<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\HTTPClientFactory;

class ClientFactory implements HTTPClientFactory
{
    private int $adapterCounter = 0;

    public function getAdapterCounter(): int
    {
        return $this->adapterCounter;
    }

    public function createRequest(string $method, string $uri): HTTPClientRequest
    {
        return new ClientRequest($method, $uri);
    }

    public function createAdapter(?callable $handler = null): HTTPClientAdapter
    {
        $this->adapterCounter++;

        $adapter = new ClientAdapter();

        if ($handler !== null) {
            $adapter->setHandler($handler);
        }

        return $adapter;
    }
}
