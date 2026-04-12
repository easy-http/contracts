<?php

namespace EasyHTTP\Contracts\Common\Request;

use EasyHTTP\Contracts\Contracts\BodyPayload\ResourceBodyPayloadContract;
use InvalidArgumentException;

class ResourceBodyPayload implements ResourceBodyPayloadContract
{
    protected $payload;

    /**
     * @param resource $payload
     */
    public function __construct($payload)
    {
        if (!is_resource($payload)) {
            throw new InvalidArgumentException('ResourceBodyPayload expects a valid resource.');
        }

        $this->payload = $payload;
    }

    /**
     * @return resource
     */
    public function getContents()
    {
        return $this->payload;
    }
}
