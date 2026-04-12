<?php

namespace EasyHTTP\Contracts\Contracts\BodyPayload;

interface JsonBodyPayloadContract extends BodyPayloadContract
{
    /**
     * Returns an array of key -> value pairs to be sent as JSON
     * Ex: ['foo' => 'bar', 'flag' => true]
     *
     * @return array
     */
    public function getContents(): array;
}
