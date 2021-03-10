# Session expired message for your Laravel application
[![EPSI CI](https://github.com/Quantical-Solutions/package-session-out/actions/workflows/blank.yml/badge.svg?branch=main)](https://github.com/Quantical-Solutions/package-session-out/actions/workflows/blank.yml)
<small>Upgraded version from <a href="https://github.com/devsrv/laravel-session-out" target="_blank">devsrv / laravel-session-out</a> which was not maintained since Laravel v5.* so big thx to <b>devsrv</b> for that awesome work !</small>

If for any reason _**( user logged out intentionally / session lifetime expired / session flushed for all logged in devices of the user )**_ the authentication session doesn't exist & still the user is on a page or multiple pages which require the user to be logged in, then showing a message that

> authentication session no longer available & to continue your current activity _( may be in the middle of posting an unsaved post etc. )_, you are advised to login again

and right after user logged in then hiding the message is all about this package.


## 📥  Installation

You can install the package via composer:

```bash
composer require quantical-solutions/laravel-session-out
```

> Laravel 5.5+ users: this step may be skipped, as we can auto-register the package with the framework.

```php

// Add the ServiceProvider to the providers array in
// config/app.php

'providers' => [
    '...',
    'Quantic\SessionOut\SessionExpiredServiceProvider::class',
];
```

You need to publish the `blade`, `js`, `css` and `config` files included in the package using the following artisan command:
```bash
php artisan vendor:publish --provider="Quantic\SessionOut\SessionExpiredServiceProvider"
```


## ⚗️ Usage

just include the blade file to all the blade views which are only available to authenticated users.

```php
@include('vendor.session-out.notify')
```

> rather copying this line over & over to the views, extend your base blade view and include it there in the bottom



## 🛠  Configuration

#### ✔ The Config File

publishing the vendor will create `config/expired-session.php` file

```php
return [
    
    // whether using broadcasting feature to make the modal disappear faster
    'avail_broadcasting' => false,
];
```

#### ✔ If you want to take advantage of broadcasting

> ** if you are using `avail_broadcasting = true` i.e. want to use the Laravel Echo for faster output please follow the below steps

1. setup [broadcasting](https://laravel.com/docs/master/broadcasting) for your app
and start `usersession` queue worker
```bash
php artisan queue:work --queue=default,usersession
```

2. make sure to put the broadcasting client config `js` file after the `@include` line not below it, in your blade view.
```php
@include('vendor.session-out.notify')
```
> Don't forget to include the require("./session" in resources/js/app.js) just after the last require.
```js
require("./bootstrap");
require("alpinejs");
require("./session");

// Your JavaScript code...
```
3. in `App\Providers\BroadcastServiceProvider` file in the `boot` method require the package's channel file, it contains private channel authentication
```php
require base_path('vendor/quantical-solutions/session-out-modal-laravel/src/routes/channels.php');
```
4. in all the places from where users are authenticated call `Quantic\SessionOut\Classes\AuthState::sessionAvailable()` .
if you are using custom logic to login users then put the line inside your authentication method when login is successful. 
> if you are using laravel's default authentication system then better choice will be to create a listener of the login event, Example :-
```php
// App\Providers\EventServiceProvider

protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\SuccessfulLogin',
        ],
    ];
```

```php
// App\Listeners\SuccessfulLogin

use Quantic\SessionOut\Classes\AuthState;

/**
* Handle the event.
*
* @param  Login  $event
* @return void
*/
public function handle(Login $user)
{
	AuthState::sessionAvailable();
}
```
5. Got to the VerifyCsrfToken Middleware file and add '/check-auth' in the excluded URIs array
```php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/check-auth',
        '/session',
        '/rebirth-session'
    ];
}
```

6. Finally uncomment et use your presets from .env file to fill the Echo params in resources/js/bootstrap.js
```js
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
     broadcaster: 'pusher',
     key: process.env.MIX_PUSHER_APP_KEY,
     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
     forceTLS: true
});
```

> Don't forget to install Echo & Pusher
> 
```bash
npm install --save-dev laravel-echo pusher-js
npm run dev
```
#### ✔ Update the modal design & contents

The modal is created with pure `js` and `css` no framework has been used, so you can easily customize the modal contents by editing the `views/vendor/session-out/modal.blade.php` & the design by editing `public/vendor/session-out/css/session-modal.css`

#### ✔ Advanced

- 🔘 if you want to customize the `js` file which is responsible for checking auth session & modal display then modify the `resources/js/session.js`

> after ajax success close the modal by calling the `closeSessionOutModal()` function


## 🧐📑 Note

#### ♻ When updating the package

Remember to publish the `assets`, `views` and `config` after each update

use `--force` tag after updating the package to publish the **updated latest** package `assets`, `views` and `config` 
> but remember using _--force_ tag will replace all the publishable files

```bash
php artisan vendor:publish --provider="Quantic\SessionOut\SessionExpiredServiceProvider" --force

php artisan vendor:publish --provider="Quantic\SessionOut\SessionExpiredServiceProvider" --tag=public --force
```

> when updating the package take backup of the `config/expired-session.php` file & `resources/js/session.js`, `views/vendor/session-out` directories as the files inside these dirs are configurable so if you modify the files then the updated published files will not contain the changes, though after publishing the `assets`, `views` and `config` you may again modify the files

#### 🔧 After you tweak things

Run this artisan command after changing the config file.
```bash
php artisan config:clear
php artisan queue:restart // only when using broadcasting
```
