<?php

namespace EasyHTTP\Contracts\Common\Request;

use EasyHTTP\Contracts\Contracts\BodyPayload\StringBodyPayloadContract;

class StringBodyPayload implements StringBodyPayloadContract
{
    protected string $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    public function getContents(): string
    {
        return $this->payload;
    }
}
