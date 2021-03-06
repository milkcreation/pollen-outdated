# Pollen Outdated Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/outdated-browser/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Outdated Browser** Component provides a solution to notify users when their web browser is out of date.

## Installation

```bash
composer require pollen-solutions/outdated
```

## Basic Usage


## Pollen Framework Setup

### Declaration

```php
// config/app.php
use Pollen\Outdated\OutdatedServiceProvider;

return [
      //...
      'providers' => [
          //...
          OutdatedServiceProvider::class,
          //...
      ]
      // ...
];
```

### Configuration

```php
// config/outdated.php

// @see /vendor/pollen-solutions/outdated/resources/config/outdated.php
return [
      // [...]
];
```
