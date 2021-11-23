# php-filesystem

A simple PHP utility to help with filesystem actions.

## Install

Install package with composer

```
composer require http-tom/php-filesystem
```

## How to use

```php
require_once 'vendor/autoload.php';
```

Determine if incoming contents has changed from what is stored

```php
use HttpTom\Filesystem\LocalStore;
$ls = new LocalStore();
$changed = $ls->isUpdated($localFilename, $incomingContents, $overwriteIfChanged = true);
```

Unzip all zip files in path and all sub folders within

```php
$zip = new Unzipper();
$zip->unzipAll('./');
```

