# Create Cruddy Tests in Laravel
[![Latest Version](https://img.shields.io/github/release/modulero/cruddy-tests.svg?style=flat-square)](https://github.com/modulero/cruddy-tests/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/modulero/cruddy-tests.svg?style=flat-square)](https://packagist.org/packages/modulero/cruddy-tests)

This package provides an easy way to create CRUD-based feature tests.

## Installation

You can install this package via composer using:

```bash
composer require --dev modulero/cruddy-tests
```

The package will automatically register itself.

To publish the config file to `config/cruddy-tests.php` run:

```bash
php artisan vendor:publish --provider="Modulero\CruddyTests\CruddyTestsServiceProvider"
```

This will publish a file named `cruddy-tests.php` in your config directory with the following contents:

```php
<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Default Resource Abilities
    |--------------------------------------------------------------------------
    |
    | This array of abilities will be used to determine which cruddy tests need
    | to be created. Feel free to change this into something you want.
    |
    */
   
    'abilities' => [
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
    ],

];
```

## Usage

After you've installed the package and optionally overwritten the values in the config-file, working with this package will be a breeze. 

The only thing you need to do is call the artisan command:

```bash
php artisan make:cruddy-tests Foo
```

This will create a folder in the Tests\Feature namespace with the name `Foo`. In this folder files will be created based on the resource abilities in your config. With the default config it will create these files:

+ ViewAnyFooTest
+ ViewFooTest
+ CreateFooTest
+ UpdateFooTest
+ DeleteFooTest

Certain resources might not need all the available abilities. In that case you can use the options `--only` and `--except`.

```bash
php artisan make:cruddy-tests Foo --only=create
```

```bash
php artisan make:cruddy-tests Foo --except=view,delete
```

You can add multiple abilities through a comma-separated list. The names need to match the ones in your config file. It is not recommended to use both options at the same time. When you do the `--only` option takes precedence over `--except`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes.

## Security

If you discover any security related issues, please email [richard@modulero.nl](mailto:richard@modulero.nl) instead of using the issue tracker.

## Credits

- [Richard Hansma](https://github.com/richje22)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
