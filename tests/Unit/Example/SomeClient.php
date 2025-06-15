<?php

namespace EasyHttp\Contracts\Tests\Unit\Example;

use EasyHttp\Contracts\AbstractClient;
use EasyHttp\Contracts\Contracts\HttpClientAdapter;
use EasyHttp\Contracts\Contracts\HttpClientRequest;

class SomeClient extends AbstractClient
{
    private int $adapterCounter = 0;

    public function getAdapterCounter(): int
    {
        return $this->adapterCounter;
    }

    protected function buildRequest(string $method, string $uri): HttpClientRequest
    {
        return new ClientRequest($method, $uri);
    }

    protected function buildAdapter(): HttpClientAdapter
    {
        $this->adapterCounter++;

        $client = new ClientAdapter();

        if ($this->hasHandler()) {
            $client->setHandler($this->handler);
        }

        return $client;
    }
}
