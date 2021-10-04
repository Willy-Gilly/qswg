# My own QuickStart as laravel package

[![N|Solid](https://laravel.com/img/logomark.min.svg)](https://laravel.com/) [![N|Solid](https://laravel.com/img/logotype.min.svg)](https://laravel.com/)

I did that because i'm doing those things each time I start a new project, so basically, wasting my time doing repetitives things, and when a task is repetitive, let's make something doing it for us.

- I still use AdminLTE package
- Things might change over the time
- If you think i wasted time on this, well yes, maybe, but at least I learned how to make a package and that's a great experiance.

## Features

- Making controllers extending from one other controller faster
- Command to make blade views based on AdminLTE pages
- Lang discreatly used

## Making a controller extending from an other :
(careful, I just reverted "controller" and "make" from the original one)
```sh
    php artisan controller:make {controllerName} {extendsName}
```
Will create a folder (if not existing) : `app\Http\Controllers\ExtendingName`
Then make your controller `app\Http\Controllers\{ExtendingName}\{ControllerName}{ExtendingName}Controller.php`
It will use correct namespace and extends from {ExtendingName}Controller (will use parent constructor)

## Making lang files

```sh
    php artisan make:lang {name}
```
Will create lang files into `resources\lang\{langs}` where {langs} is an array of langs in `config\qswg.php`

## Making view files

```sh
    php artisan make:view {name} {path}
```
Will create a PHP Blade file into `resources\views\{path}\{name}.blade.php` (leave path blank to make it in the root of views folder)
It uses AdminLTE's Blank page
## Tech

- Laravel
- AdminLTE
- Blade

## Installation

With Composer : 
```sh
composer require willy-gilly/qswg
```

It requires Laravel AdminLTE, if you didn't installed it yet, maybe use the shell script here next time :
Github : https://github.com/Willy-Gilly/Laravel-Auth-AdminLTE-Installer
You also might use Laravel Passport to use `app\Http\Controllers\API\LoginController.php`

```sh
php artisan qswg:install
```

Add the following things into `app\Http\Kernel.php` :

```php
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\ForceJsonResponse;
```
```php
protected $middleware = [
        'setLocale' => SetLocale::class,
        //ForceJsonResponse::class,
    ];
```
```php 
 protected $routeMiddleware = [
         'setLocale' => SetLocale::class,
        'json.response' => ForceJsonResponse::class,
    ];
```

# You can also add lang menu into AdminLTE config file
So go into `config/adminlte.php` and add the following into the menu :
```php
//lang
        [
            'text' => 'language',
            'icon' => 'fas fa-language',
            'icon_color' => 'red',
            'topnav_right' => 'true',
            'submenu' => [
                [
                    'text' => 'english',
                    'icon' => 'flag-icon flag-icon-gb',
                    'url' => 'setLang/en',
                ],
                [
                    'text' => 'french',
                    'icon' => 'flag-icon flag-icon-fr',
                    'url' => 'setLang/fr',
                ],
                [
                    'text' => 'german',
                    'icon' => 'flag-icon flag-icon-de',
                    'url' => 'setLang/de',
                ],
                [
                    'text' => 'spanish',
                    'icon' => 'flag-icon flag-icon-es',
                    'url' => 'setLang/es',
                ],
                [
                    'text' => 'italian',
                    'icon' => 'flag-icon flag-icon-it',
                    'url' => 'setLang/it',
                ],
            ],
        ],
```
And places this into `resources\lang\vendor\adminlte\{lang}` for each lang you need to translate the words of languages as well : 
```php
    'english'                       => 'English',
    'french'                        => 'French',
    'spanish'                       => 'Spanish',
    'german'                        => 'German',
    'italian'                       => 'Italian',
```

*Of course you can remove or add any of langs you need.*
Be sure to use :
`<link rel="stylesheet" href="{{ asset('vendor/flag-icon-css/css/flag-icon.min.css')}}">`
into your main view file to get the flag icons (it is already installed into AdminLTE plugins).
## License

MIT
