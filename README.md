# Pollen Outdated Component

[![Latest Version](https://img.shields.io/badge/release-1.1.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/outdated-browser/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Outdated Browser** Component provides a solution to notify users when their web browser is out of date.

## Installation

```bash
composer require pollen-solutions/outdated
```

## Basic Usage
```php
use Pollen\Outdated\Outdated;

$outdated = new Outdated();

// CSS Styles (usually put in the head of the site)
var_dump($outdated->getStyles());

// HTML Render (usually put in the footer of the site)
var_dump($outdated->getHtmlRender());

// JS Scripts (usually put in the footer of the site)
var_dump($outdated->getScripts());
```

## Configuration
```php
use Pollen\Outdated\Outdated;

$outdated = new Outdated();

/**
 * @var string $lowerThan 
 * Edge|js:Promise (Default property)
 * IE11|borderImage
 * IE10|transform
 * IE9|boxShadow
 * IE8|borderSpacing
 * simply 'test' or any other string for tests display
 */
$outdated->setConfig([
    'lowerThan' => 'any-test-string'
]);

```

## Dependency Injection
```php
use Pollen\Container\Container;
use Pollen\Outdated\OutdatedInterface;
use Pollen\Outdated\OutdatedServiceProvider;
use Pollen\Partial\PartialServiceProvider;

$container = new Container();
$container->addServiceProvider(new OutdatedServiceProvider());
$container->addServiceProvider(new PartialServiceProvider());
$outdated = $container->get(OutdatedInterface::class);
$outdated->setConfig(['lowerThan' => 'test']);

var_dump($outdated->getHtmlRender());
var_dump($outdated->getStyles());
var_dump($outdated->getScripts());
```

## Standalone Wordpress Usage
```php
use Pollen\Outdated\Outdated;
use Pollen\Outdated\Adapters\OutdatedWordpressAdapter;

$outdated = new Outdated(['lowerThan' => 'test']);
$outdated->setAdapter(new OutdatedWordpressAdapter($outdated));
// >> And ... that's it
```

## Pollen WpApp Usage
```php
use Pollen\Outdated\OutdatedInterface;
use Pollen\Outdated\OutdatedServiceProvider;
use Pollen\WpApp\WpApp;

// Déclaration
$wpApp = new WpApp(
    [
        'service-providers' => [
            'app.outdated.service'  => OutdatedServiceProvider::class,
        ]
    ]
);

// Configuration
$outdated = $wpApp->get(OutdatedInterface::class);
$outdated->setConfig(['lowerThan' => 'Edge']);

```

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
