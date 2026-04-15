# Adapter Implementation Rules (PSR-18 Aligned)

This document defines the expected error-handling behavior for any adapter implementing `easy-http/contracts`.

## Goal

Adapters must treat valid HTTP responses as successful executions, even when the status code is `4xx` or `5xx`.

In other words:

- `400`, `401`, `404`, `422`, `500`, `503`, etc. are still valid HTTP responses.
- These responses **must** be returned as `HTTPClientResponse` objects.
- Exceptions are reserved for cases where a valid HTTP response cannot be obtained.

## Required Rules

Implementers should follow these rules:

1. **Do not throw for HTTP status codes**
   - If the upstream client returns a valid response object, return it as `HTTPClientResponse`.
   - Do not transform `4xx/5xx` responses into exceptions.

2. **Throw for transport/runtime failures**
   - Timeouts
   - Connection failures
   - DNS resolution failures
   - TLS/SSL handshake failures
   - Socket/network-level failures

3. **Throw for malformed/invalid response construction**
   - If the adapter cannot build a valid `HTTPClientResponse` from upstream output, throw an exception.

## Exception Guidance

Use these exception types consistently:

- `HTTPConnectionException`
  - Network/connection/transport failures (timeout, DNS, connection refused, TLS, etc.).
- `HTTPClientException`
  - Other request-execution failures not covered by `HTTPConnectionException`.

## Event Semantics

Given the current event model:

- `RequestSucceeded` should be emitted when a valid `HTTPClientResponse` is returned (including `4xx` and `5xx`).
- `RequestFailed` should be emitted when execution raises an exception.

This keeps event behavior deterministic across adapters and clients.

## Why This Policy

This rule set aligns adapter behavior with PSR-18 expectations:

- Well-formed HTTP responses are not exceptional, regardless of status code.
- Exceptions represent inability to complete transport or parse/build a valid response.
