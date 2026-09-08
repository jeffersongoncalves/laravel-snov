<div class="filament-hidden">

![Laravel Snov](https://raw.githubusercontent.com/jeffersongoncalves/laravel-snov/main/art/jeffersongoncalves-laravel-snov.png)

</div>

# Laravel Snov

[![Tests](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/tests.yml/badge.svg)](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/tests.yml)
[![PHPStan](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/phpstan.yml/badge.svg)](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/phpstan.yml)
[![Code Style](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/pint.yml/badge.svg)](https://github.com/jeffersongoncalves/laravel-snov/actions/workflows/pint.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-snov.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-snov)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-snov.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-snov)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-snov.svg?style=flat-square)](LICENSE.md)

A Laravel client for the [Snov.io](https://snov.io) API. A fluent `Snov` facade groups the domain search, email finder, email verifier, prospect, list, technology checker, and drip campaign endpoints behind resource accessors, mints and caches the OAuth access token for you, and throws a `SnovException` on a non-2xx response instead of returning a silent error array.

## Features

- **Domain Search** — `domains()->search()`, `count()`
- **Email Finder & Verifier** — `emails()->find()`, `verify()`
- **Prospects** — `prospects()->find()`, `addToList()`
- **Lists** — `lists()->all()`, `prospects()`
- **Technology Checker** — `technology()->check()`
- **Drip Campaigns** — `campaigns()->all()`, `emails()`, `addProspect()`
- **Token handled for you** — the client-credentials access token is minted on demand and cached until just before it expires
- **Thin by design** — every method returns the raw decoded JSON response as an array, no DTOs
- **Fails loud** — a non-2xx response throws `SnovException` carrying the API's error message and HTTP status code

## Installation

```bash
composer require jeffersongoncalves/laravel-snov
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="snov-config"
```

## Configuration

Add to your `.env`:

```env
SNOV_CLIENT_ID=your-client-id
SNOV_CLIENT_SECRET=your-client-secret
```

Generate the credentials at [https://app.snov.io/api-setting](https://app.snov.io/api-setting).

### Config Options

```php
// config/snov.php
return [
    'client_id' => env('SNOV_CLIENT_ID'),
    'client_secret' => env('SNOV_CLIENT_SECRET'),
    'base_url' => env('SNOV_BASE_URL', 'https://api.snov.io/v1'),
    'cache_key' => env('SNOV_CACHE_KEY', 'snov.access_token'),
];
```

## Usage

```php
use JeffersonGoncalves\Snov\Facades\Snov;
use JeffersonGoncalves\Snov\Exceptions\SnovException;
```

### Domain Search

```php
Snov::domains()->search('example.com', type: 'all', limit: 100);
Snov::domains()->count('example.com');
```

### Email Finder & Verifier

```php
Snov::emails()->find('Ada', 'Lovelace', 'example.com');
Snov::emails()->verify('ada@example.com');
Snov::emails()->verify(['ada@example.com', 'grace@example.com']);
```

### Prospects

```php
Snov::prospects()->find('ada@example.com');
Snov::prospects()->addToList('ada@example.com', 'Ada', 'Lovelace', listId: 12345);
```

### Lists

```php
Snov::lists()->all();
Snov::lists()->prospects(12345, page: 1, perPage: 100);
```

### Technology Checker

```php
Snov::technology()->check('example.com');
```

### Drip Campaigns

```php
Snov::campaigns()->all();
Snov::campaigns()->emails(7);
Snov::campaigns()->addProspect(7, 'ada@example.com', 'Ada', 'Lovelace');
```

### Handling errors

```php
try {
    $result = Snov::domains()->count('example.com');
} catch (SnovException $e) {
    // $e->getMessage() — the API's message/error_description, or the raw response body
    // $e->statusCode  — the HTTP status code returned by Snov.io
}
```

## Testing

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Code Formatting

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
