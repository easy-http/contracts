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

<p align="center">
    :rocket: Seamlessly switch between different HTTP client adapters using a standardized set of contracts
</p>

# HTTP Contracts

<a href="https://sonarcloud.io/component_measures?metric=security_rating&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=security_rating&branch=3.x" alt="Bugs"></a>
<a href="https://sonarcloud.io/component_measures?metric=bugs&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=bugs&branch=3.x" alt="Bugs"></a>
<a href="https://sonarcloud.io/component_measures?metric=code_smells&branch=3.x&id=easy-http_contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_contracts&metric=code_smells&branch=3.x" alt="Bugs"></a>

**A Solid set of Adapter-Driven HTTP contracts for PHP**

We provide different adapters for common HTTP Clients like Guzzle, Symfony and others.

📚 Check out the [Documentation](https://easy-http.com/docs) to learn how to use any adapter that implements these contracts.

## Philosophy

This package defines an opinionated set of HTTP contracts and interfaces that standardizes
request/response handling through a single and ergonomic interface while preserving consistency across
different adapters like Guzzle, Symfony and others.

### What this Package Provides

- It establishes a set of contracts that provide a standardized interface for working with different HTTP clients like Guzzle, Symfony, and others via adapters.
- A domain-local and solid abstraction where requests and responses intent are explicit and discoverable.
- A fluent and explicit interface for building HTTP calls that is simpler than pure PSR* implementations.

### What this project is not

- A pure PSR-7/PSR-18 package. Although you can still use Guzzle/Symfony or others via adapters.

Let's explore why pure PSR can become complex (more object orchestration). The following example
shows a common orchestration which is fully PSR compliant.

```php
$psrClient = new PsrClient();
$psr17 = new Psr17Factory();

$request = $psr17->createRequest('POST', 'https://api.example.com/users')
    ->withHeader('Content-Type', 'application/json')
    ->withBody($psr17->createStream(json_encode([
        'name' => 'John Doe',
        'role' => 'admin',
    ], JSON_THROW_ON_ERROR)));

$response = $psrClient->sendRequest($request);
```

Now, let's see how the same example looks using `easy-http/contracts` (intent-focused API).

```php
use EasyHTTP\Contracts\Common\Request\JsonBodyPayload;

$request = $client->prepareRequest('POST', 'https://api.example.com/users')
    ->setHeader('Content-Type', 'application/json')
    ->setBodyPayload(new JsonBodyPayload([
        'name' => 'John Doe',
        'role' => 'admin',
    ]));

$response = $client->execute();
```

Although some might argue that libraries like Guzzle, Symfony, or other HTTP clients provide a similarly simple interface for handling these scenarios (and that’s true), it comes with certain trade-offs.

Have you ever tried migrating an existing Guzzle implementation to Symfony or another HTTP client? If not, let me walk you through some of the challenges you might face. Guzzle is a great HTTP client, and while it relies on PSR-7 interfaces for requests, responses, and streams, some of its custom methods do not fully comply with the standard. This allows for greater flexibility when adding options, but it can also make interoperability more difficult.

The following example highlights a small difference between Guzzle and Symfony when setting up basic authentication
and SSL verification using a custom non-compliant method.

```php
use GuzzleHttp\Client;

$guzzleClient = new Client();

$guzzleClient->request(
    'GET',
    'https://api.example.com/users',
    [
        'verify' => true,
        'auth' => ['user', 'pass']
    ]
);
```

```php
use Symfony\Component\HttpClient\CurlHttpClient as SymfonyClient;

$symfonyClient = new SymfonyClient();

$symfonyClient->request(
    'GET',
    'https://api.example.com/users',
    [
        'verify_peer' => true,
        'auth_basic' => ['user', 'pass']
    ]
);
```

It might seem simple, but you might want to avoid this kind of deviations. Here's how we would do it using
the HTTP contracts this library provides:

```php
$request = $client->prepareRequest('GET', 'https://api.example.com/users')
    ->ssl(true)
    ->setBasicAuth('user', 'pass');

$response = $client->execute(); // or $stream = $client->stream();
```

The backend implementation behind this interface can still use Guzzle. We provide adapters for multiple
HTTP clients. You can later swap the underlying implementation if needed, so you have the best of both worlds:
a well-established and solid interface on top of your favorite client.