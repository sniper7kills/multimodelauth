# MultiModelAuth
This package is designed to allow multiple models to be used for authentication in laravel without having to switch guards.

## Notes
This package does not currently support passport authentication

## Installation
Via Composer
`composer require sniper7kills\multimodelauth`


## Setting up
### Config
In your config, create a new provider that uses the `multi-model` driver, and specify which models can be authenticated against.

**Note:** The models should be listed in the order that they should be checked.
```php
    'providers' => [
        'multi-model' => [
            'driver' => 'multi-model',
            'models' => [App\User::class, App\Admin::class],
        ],
    ],
```
Then update your guard to use the new provider you created.
```php
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'multi-model',
        ],
    ],
```

### Models
Update your models listed in the provider to use the `Sniper7Kills\MultiModelAuth\MultiModelAuthTrait` trait
```php
use Sniper7Kills\MultiModelAuth\MultiModelAuthTrait;

class User extends Authenticatable
{
    use MultiModelAuthTrait;
}
```

### Migrations
Add the following line to your "user(s)" migration files
```php
$table->string('auth_identifier')->nullable()->unique();
```
(This may not be required in future versions, and is currently present due to trying to integrate with laravel/passport)

