<?php

namespace EasyHTTP\Contracts\Contracts\BodyPayload;

interface UrlEncodedBodyPayloadContract extends BodyPayloadContract
{
    /**
     * Returns an array of key -> value pairs to be sent as URL-encoded form data
     * Ex: ['foo' => 'bar', 'flag' => true]
     *
     * @return array
     */
    public function getContents(): array;
}
