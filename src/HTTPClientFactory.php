<?php

namespace EasyHTTP\Contracts;

use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;

interface HTTPClientFactory
{
    public function createRequest(string $method, string $uri): HTTPClientRequest;
    public function createAdapter(?callable $handler = null): HTTPClientAdapter;
}
