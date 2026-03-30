<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use EasyHTTP\Contracts\AbstractClient;

class SomeClient extends AbstractClient
{
    private ClientFactory $clientFactory;

    public function __construct()
    {
        $this->clientFactory = new ClientFactory();
        parent::__construct($this->clientFactory);
    }

    public function getAdapterCounter(): int
    {
        return $this->clientFactory->getAdapterCounter();
    }
}
