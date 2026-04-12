<?php

namespace EasyHTTP\Contracts\Common\Request;

use EasyHTTP\Contracts\Contracts\BodyPayload\JsonBodyPayloadContract;

class JsonBodyPayload implements JsonBodyPayloadContract
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
