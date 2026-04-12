<?php

namespace EasyHTTP\Contracts\Contracts\BodyPayload;

interface StringBodyPayloadContract extends BodyPayloadContract
{
    public function getContents(): string;
}
