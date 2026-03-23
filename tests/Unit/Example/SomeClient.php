<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use EasyHTTP\Contracts\AbstractClient;
use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;

class SomeClient extends AbstractClient
{
    private int $adapterCounter = 0;

    public function getAdapterCounter(): int
    {
        return $this->adapterCounter;
    }

    protected function buildRequest(string $method, string $uri): HTTPClientRequest
    {
        return new ClientRequest($method, $uri);
    }

    protected function buildAdapter(): HTTPClientAdapter
    {
        $this->adapterCounter++;

        $client = new ClientAdapter();

        if ($this->hasHandler()) {
            $client->setHandler($this->handler);
        }

        return $client;
    }
}
