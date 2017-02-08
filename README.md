# Base
Laravel wrapper for commonly used package and crud generators for basic crud functionalities

### Installation

+ Install using **composer**

   ```

    composer require adifaidz/base

   ```

+ Register the service provider to your **providers** array in **config/app.php**

  ```

    AdiFaidz\Base\Providers\BaseServiceProvider::class,

  ```

+ Add this to the **boot** method in **app\Providers\AppServiceProvider.php** to register all package routes

  ```
    use AdiFaidz\Base\Base;

    ...

    Base::routes();

  ```

+ Run the **install** command using **artisan**, this will register guards, providers, password broker, route middlewares and middleware groups.

  ```

    php artisan base:install

  ```

+ Change the auth users provider model in config/auth.php to

  ```

    'users' => [
        'driver' => 'eloquent',
        'model' => AdiFaidz\Base\BaseUser::class,
    ],

  ```

+ Next, publish all **public assets** to get you working using **publish** command

  ```

    php artisan vendor:publish --tag=public --force

  ```

+ After that, **configure your database connection** and run **migrate**. Upon completion, tables for **users, roles, permissions** will be created

  ```

    php artisan migrate

  ```

+ Seed the tables

  ```

    php artisan db:seed --class=AdiFaidz\Base\Seeders\StartupSeeder

  ```

+ Then, replace the **current** ExceptionHandler in **bootstrap/app.php** with Base ExceptionHandler class.

  ```

    $app->singleton(
      Illuminate\Contracts\Debug\ExceptionHandler::class,
      AdiFaidz\Base\Exceptions\Handler::class
    );

  ```
+ **Lastly**, **start** up your **server** and go to

  ```

    http://localhost/login

  ```
