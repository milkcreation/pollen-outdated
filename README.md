# Outdated Browser Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/outdated-browser/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

**Outdated Browser** provide a good solution to notify users when their web browser is out of date.

## Installation

```bash
composer require pollen-solutions/outdated-browser
```

## Pollen Framework Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \Pollen\OutdatedBrowser\OutdatedBrowserServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/theme-suite.php
// @see /vendor/pollen-solutions/outdated-browser/resources/config/outdated-browser.php
return [
      //...

      // ...
];
```
