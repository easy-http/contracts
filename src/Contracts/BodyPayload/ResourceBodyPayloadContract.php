<?php

namespace EasyHTTP\Contracts\Contracts\BodyPayload;

interface ResourceBodyPayloadContract extends BodyPayloadContract
{
    /**
     * @return resource
     */
    public function getContents();
}
