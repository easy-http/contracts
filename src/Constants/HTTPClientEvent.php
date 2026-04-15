<?php

namespace EasyHTTP\Contracts\Constants;

final class HTTPClientEvent
{
    public const REQUEST_STARTED = 'request.started';
    public const REQUEST_SUCCEEDED = 'request.succeeded';
    public const REQUEST_FAILED = 'request.failed';
}
