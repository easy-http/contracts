<?php

namespace EasyHTTP\Contracts\Common\Request;

use EasyHTTP\Contracts\Contracts\BodyPayload\UrlEncodedBodyPayloadContract;

class UrlEncodedBodyPayload implements UrlEncodedBodyPayloadContract
{
    protected array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getContents(): array
    {
        return $this->payload;
    }
}
