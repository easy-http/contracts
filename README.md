<p align="center"><img style="max-width: 100%; width: 200px;" src="https://blog.pleets.org/img/articles/easy-http-logo-320.png"></p>

<p align="center">
<a href="https://github.com/easy-http/contracts/actions/workflows/tests.yml"><img src="https://github.com/easy-http/contracts/actions/workflows/tests.yml/badge.svg?branch=3.x" alt="Build Status"></a>
<a href="https://sonarcloud.io/component_measures?metric=reliability_rating&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=reliability_rating&branch=3.x" alt="Bugs"></a>
<a href="https://sonarcloud.io/component_measures?metric=coverage&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=coverage&branch=3.x" alt="Bugs"></a>
</p>
<p align="center">
    <a href="#tada-php-support" title="PHP Versions Supported"><img alt="PHP Versions Supported" src="https://img.shields.io/badge/php-7.4%20to%208.3-777bb3.svg?logo=php&logoColor=white&labelColor=555555"></a>
</p>

<p align="center"><img src="https://blog.pleets.org/img/articles/easy-http-contracts.png" style="max-width: 100%; width: 400px;"></p>

# Easy HTTP Contracts

<a href="https://sonarcloud.io/component_measures?metric=security_rating&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=security_rating&branch=3.x" alt="Bugs"></a>
<a href="https://sonarcloud.io/component_measures?metric=bugs&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=bugs&branch=3.x" alt="Bugs"></a>
<a href="https://sonarcloud.io/component_measures?metric=code_smells&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=code_smells&branch=3.x" alt="Bugs"></a>

**Add testing, resilience, and data handling to any PHP HTTP client.**

Easy HTTP is a **capabilities layer** designed to enhance existing clients like Guzzle, Symfony, and other clients.

If you are already using PSR-18, Easy HTTP is designed to complement your existing setup.
It focuses on capabilities that PSR does not provide out of the box.

📚 For full documentation, visit [easy-http.com/docs](https://easy-http.com/docs).

## Why Easy HTTP?

PSR standards solved interoperability by giving libraries a shared language for requests, responses, and client behavior,
so packages can swap HTTP implementations without rewriting all integration points.
But in real-world applications, teams still end up re-implementing:

- Logging and observability
- Retries and resilience
- Testing and mocking
- DTO hydration
- Consistent developer experience

Easy HTTP aims to provide these capabilities on top of any client.

## The Idea

The idea is to add practical capabilities your client stack usually does not provide out of the box:

- observability
- resilience
- testing ergonomics
- data mapping and developer experience

Easy HTTP brings these superpowers to your existing HTTP client strategy:

```text
Your App
   ↓
Easy HTTP (Capabilities Layer)
   ↓
PSR-18 Client (Guzzle, Symfony, etc.)
```

- Keep your client
- Gain superpowers

## Current Scope in this Repository

This package (`easy-http/contracts`) defines shared contracts and event primitives used by adapters and capabilities.

Notable pieces include:

- `HTTPClientAdapter`, `HTTPClientRequest`, `HTTPClientResponse`, `HTTPStreamResponse`
- Event contracts and lifecycle events (`request.started`, `request.succeeded`, `stream.succeeded`, `request.failed`)
- Adapter implementation rules for exception handling in `docs/adapter-implementation-rules.md`

## Core Features

### Observability (Planned)

```php
$http->withLogging($logger)->get('/users');
```

- logging
- metrics
- tracing hooks

### Resilience (Planned)

```php
$http->withRetry(3)->get('/users');
```

- retries and backoff
- circuit breakers
- fallback strategies

### Advanced Testing (Coming Soon)

Advanced testing capabilities are planned and will be documented once implementation is available.

### DTO Hydration

Turn JSON responses into typed objects with a Laravel-friendly style:

```php
$response = $http->get('/users/1');
$user = UserData::from($response->json());

$response = $http->get('/users');
$users = collect($response->json('data'))->mapInto(UserData::class);
```

Planned support includes:

- validation hooks
- strict and flexible modes
- framework-agnostic usage

## Works With Your Stack

Easy HTTP is designed to integrate with:

- Guzzle
- Symfony HTTP Client
- Any PSR-18 client

No lock-in. No replacement.

## Design Philosophy

1. **Do not replace standards**
   - PSR already solved HTTP abstraction.
2. **Add real-world capabilities**
   - Focus on problems developers face in application code.
3. **Stay client-agnostic**
   - Adapt behavior to the underlying implementation.
4. **Prioritize developer experience**
   - Keep common tasks expressive and easy to maintain.

## Package Roadmap (Planned)

- `core` -> capability pipeline and adapters
- `testing` -> mocks, assertions, replay
- `dto` -> hydration and validation
- `resilience` -> retries and circuit breakers
- `observability` -> logging and metrics

## Who Is This For?

- Developers building API integrations
- Teams that care about testing quality
- Projects using clean architecture boundaries
- Anyone tired of repetitive HTTP boilerplate

## What This Is Not

- Not an HTTP client
- Not a PSR replacement
- Not abstraction for abstraction's sake

## Vision

Easy HTTP aims to become the missing layer between HTTP clients and real-world applications.

## Status

Early stage. Direction recently redefined. Expect rapid iteration.

## Contributing

This project is evolving toward a capabilities-first approach.

Contributions are welcome, especially around:

- testing tools
- DTO systems
- resilience patterns
- observability primitives

## License

MIT