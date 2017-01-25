# Base
Laravel wrapper for commonly used package and crud generators for basic crud functionalities

### Installation

+ Install using **composer**

   ```

    composer require adifaidz/base dev-master

   ```

+ Register the service provider to your **providers** array in **config/app.php**

  ```

    AdiFaidz\Base\Providers\BaseServiceProvider::class,

  ```

+ Add this to the **boot** method in **AppServiceProvider.php** to register all package routes

  ```

    Base::routes();

  ```

+ Run the **install** command using **artisan**, this will register guards, provider, password broker, route middlewares and middleware groups.

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

+ After that, configure your database connection and run **migrate**. Upon completion, tables for **users, roles, permissions** will be created

  ```

    php artisan migrate

  ```

+ Lastly seed the tables

  ```

    php artisan db:seed --class=AdiFaidz\Base\Seeders\StartupSeeder

  ```
