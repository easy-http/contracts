<?php

namespace EasyHTTP\Contracts\Common\Request;

use EasyHTTP\Contracts\Contracts\BodyPayload\IterableBodyPayloadContract;

class IterableBodyPayload implements IterableBodyPayloadContract
{
    protected iterable $payload;

    public function __construct(iterable $payload)
    {
        $this->payload = $payload;
    }

    public function getContents(): iterable
    {
        return $this->payload;
    }
}
