<?php

namespace EasyHTTP\Contracts\Contracts\Observability;

final class HTTPClientEventNames
{
    public const REQUEST_STARTED = 'request.started';
    public const REQUEST_SUCCEEDED = 'request.succeeded';
    public const REQUEST_FAILED = 'request.failed';
}
