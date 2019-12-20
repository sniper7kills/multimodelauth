# MultiModelAuth
This package is designed to allow multiple models to be used for authentication in laravel without having to switch guards.

## Notes
This package does not currently support passport authentication

## Installation
TODO

## Setting up
Edit your `config/auth.php` file.
```php

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'multi-model',
        ],
    ],
...
    'providers' => [
        'multi-model' => [
            'driver' => 'multi-model',
            'models' => [App\User::class, App\Admin::class],
        ],
    ],
```
Update your models
```php
use Sniper7Kills\MultiModelAuth\MultiModelAuthTrait;

class User extends Authenticatable
{
    use MultiModelAuthTrait;
}
```
Add the following line to your "user(s)" migration files
```php
$table->string('auth_identifier')->nullable()->unique();
```

