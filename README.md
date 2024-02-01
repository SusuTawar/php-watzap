# Watzap API

Unofficial PHP wrapper for watzap.id

## Table Of Contents

- [Watzap API](#watzap-api)
  - [Table Of Contents](#table-of-contents)
  - [Installation](#installation)
    - [Laravel](#laravel)
  - [Usage](#usage)
  - [Laravel Usage](#laravel-usage)

## Installation

install the package

```bash
composer require susutawar/php-watzap
```

### Laravel

publish the config file to be used in Laravel project

```bash
php artisan vendor:publish --tag=watzap
```

add `WATZAP_API_KEY` to your .env

## Usage

To use the package, create an instance of `PhpWatzap/WatZap`

```php
use PhpWatzap/WatZap;

// ...

$watzapClient = new WatZap("MY_API_KEY");

$result = $watzapClient->apiKey();

$resultBody = $result->body;
```

## Laravel Usage

run `php artisan watzap:keys` to get your whatsapp number key

```php
use PhpWatzapp/Facade/Watzap;

// ...

$result = Watzap::apiKey();

$resultBody = $result->body;
```
