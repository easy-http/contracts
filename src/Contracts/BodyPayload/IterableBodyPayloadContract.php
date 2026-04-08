<?php

namespace EasyHTTP\Contracts\Contracts\BodyPayload;

interface IterableBodyPayloadContract extends BodyPayloadContract
{
    public function getContents(): iterable;
}
