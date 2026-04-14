# Release Notes

## [v3.0.0 (Unreleased)](https://github.com/easy-http/contracts/tree/v3.0.0)

### Changed
- Standardized root namespace from `EasyHttp` to `EasyHTTP`. ([#3](https://github.com/easy-http/contracts/pull/3)).
- Standardized artifact names from `Http*` to `HTTP*`. ([#3](https://github.com/easy-http/contracts/pull/3))
- Renamed `EasyClientContract` to `HTTPClientContract`. ([#4](https://github.com/easy-http/contracts/pull/4))
- Renamed `ImpossibleToParseJsonException` to `HTTPJsonParseException`. ([#5](https://github.com/easy-http/contracts/pull/5))
- Introduced `HTTPClientFactory` and refactored `AbstractClient` to create requests and adapters through factory methods. ([#6](https://github.com/easy-http/contracts/pull/6))
- Added streaming support to `AbstractClient`/`HTTPClientContract` via `stream()` and extended `HTTPClientAdapter` with `stream(HTTPClientRequest $request): HTTPStreamResponse`. ([#8](https://github.com/easy-http/contracts/pull/8))
- Refactored `HTTPClientRequest`/`ClientRequest` to use `BodyPayloadContract` as the canonical request body abstraction. ([#9](https://github.com/easy-http/contracts/pull/9))
- Created dedicated body payload interfaces (e.g. `StringBodyPayloadContract`, `JsonBodyPayloadContract`, `IterableBodyPayloadContract`, `ResourceBodyPayloadContract`, and `UrlEncodedBodyPayloadContract`) that replace previous tailored methods in requests. ([#9](https://github.com/easy-http/contracts/pull/9))
- Added request lifecycle event emission in `AbstractClient` for `call()`, `execute()`, and `stream()` flows. ([#10](https://github.com/easy-http/contracts/pull/10))

### Added
- URL-encoded request data support to `HTTPClientRequest`/`ClientRequest` via `setUrlEncodedData()`, `getUrlEncodedData()`, and `hasUrlEncodedData()`. ([#7](https://github.com/easy-http/contracts/pull/7))
- Introduced `HTTPStreamResponse` contract. ([#8](https://github.com/easy-http/contracts/pull/8))
- Added `setBodyPayload()` and `getBodyPayload()` to `HTTPClientRequest`/`ClientRequest`. ([#9](https://github.com/easy-http/contracts/pull/9))
- Added dedicated body payload contracts and implementations for string, JSON, iterable, resource, and URL-encoded payloads. ([#9](https://github.com/easy-http/contracts/pull/9))
- Added standardized observability event contracts (`request.started`, `request.succeeded`, and `request.failed`) with PSR-14 dispatcher integration. ([#10](https://github.com/easy-http/contracts/pull/10))
- Added `withEventDispatcher()` to `HTTPClientContract` for plugging PSR-14 dispatchers. ([#10](https://github.com/easy-http/contracts/pull/10))

### Removed
- Removed `getJson()`, `setJson()`, and `hasJson()` from `HTTPClientRequest` and `ClientRequest`. ([#9](https://github.com/easy-http/contracts/pull/9))
- Removed `getBody()`, `setBody()`, and `hasBody()` from `HTTPClientRequest` and `ClientRequest`. ([#9](https://github.com/easy-http/contracts/pull/9))
- Removed `getUrlEncodedData()`, `setUrlEncodedData()`, and `hasUrlEncodedData()` from `HTTPClientRequest` and `ClientRequest` in favor of URL-encoded body payloads. ([#9](https://github.com/easy-http/contracts/pull/9))

## [v2.0.0 (2025-06-15)](https://github.com/easy-http/contracts/tree/v2.0.0)

### Changed
- Renamed project from [layer-contracts](https://github.com/easy-http/layer-contracts) to [contracts](https://github.com/easy-http/contracts) for improved clarity
- Updated namespace from `EasyHttp\LayerContracts` to `EasyHttp\Contracts`
- Updated all documentation and badges to reflect the new project name
- Deprecate Scrutinizer CI and use SonarCloud for code quality metrics

### Deprecation Notice
- The original `easy-http/layer-contracts` package is now deprecated
- Users are encouraged to migrate to `easy-http/contracts` v2.0.0
- No functional changes were made in this release, only naming improvements

