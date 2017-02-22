# Base

Laravel wrapper for commonly used package and crud generators for basic crud functionalities

## Before you start, read this

- This package

  - Is a **Laravel (Currently 5.4) package**

  - Is still under **heavy development** :loudspeaker: :construction:

  - Uses mainly **[Laravel][1], [Vue][2], [Bootstrap][3] and [Laravel-Mix][8]**

  - **Affects** some **settings** on installation :warning:

  - **Uses** these **npm** packages:

    - **admin-lte : ^2.3.8**
    - **axios: ^0.15.2**
    - **babel-plugin-transform-runtime: ^6.23.0**
    - **babel-preset-stage-2: ^6.22.0**
    - **bootstrap-sass: ^3.3.7**
    - **eonasdan-bootstrap-datetimepicker: ^4.17.43**
    - **font-awesome: ^4.7.0**
    - **jquery: ^3.1.0**
    - **laravel-mix: ^0.8.1**
    - **lodash: ^4.17.4**
    - **string-replace-loader: ^1.0.5**
    - **toastr: ^2.1.2**
    - **vue: ^2.0.1**
    - **vue-multiselect: 2.0.0-beta.13**
    - **vue-resource: ^1.0.3**
    - **vuetable-2: ^0.9.2**

## Features

- Ready to use base functionalities **(user profile, login, acl, etc )**

- Create crud components **(views, controller, routes)** based on eloquent model

- Debug using **[phpdebugbar][4]** and **[logviewer][5]** based on your **environment**

- Clean project using **[clean][6]**

- Easily create menus with **[laravel-menu][7]**

## Installation

- Install using **composer**

  ```

    composer require adifaidz/base
  ```

- Register the service provider to your **providers** array in **config/app.php**

  ```

    AdiFaidz\Base\Providers\BaseServiceProvider::class,
  ```

- Run the **install** command using **artisan**, this will register guards, providers, password broker, route middlewares and middleware groups. It will also publish vue components, assets and bundling scripts.

  ```

    php artisan base:install
  ```

- After that, **configure your database connection** and run **migrate**. Upon completion, tables for **users, roles, permissions** will be created

  ```

    php artisan migrate
  ```

- Seed the tables

  ```

    php artisan db:seed --class="AdiFaidz\Base\Seeders\StartupSeeder"
  ```

- Add this to the **boot** method in **app\Providers\AppServiceProvider.php** to register all package routes

  ```

    use AdiFaidz\Base\Base;

    ...

    Base::routes();
  ```

- Change the auth users provider model in config/auth.php to

  ```

    'users' => [
        'driver' => 'eloquent',
        'model' => AdiFaidz\Base\BaseUser::class,
    ],
  ```

- Then, replace the **current** ExceptionHandler in **bootstrap/app.php** with Base ExceptionHandler class.

  ```

    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        AdiFaidz\Base\Exceptions\Handler::class
    );
  ```

- After that, run

  ```

    npm install && npm run watch

    or

    npm install && npm run dev
  ```

- **Lastly**, **start** up your **server** and go to

  ```

    http://localhost/login
  ```

## Todo :computer: :watch:

- Create form and detail view based on model attributes

- Fallback to **[mailtrap][9]** in **development environment**

- Detailed documentation

- Provide better flow

[1]: https://laravel.com
[2]: http://vuejs.org
[3]: https://getbootstrap.com
[4]: https://github.com/barryvdh/laravel-debugbar
[5]: https://github.com/rap2hpoutre/laravel-log-viewer
[6]: https://github.com/adifaidz/clean
[7]: https://github.com/lavary/laravel-menu
[8]: https://github.com/JeffreyWay/laravel-mix
[9]: https://mailtrap.io
