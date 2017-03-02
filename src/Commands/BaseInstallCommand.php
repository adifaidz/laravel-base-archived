<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class BaseInstallCommand extends Command
{
    protected $signature = 'base:install';

    protected $description = 'Installs base package';

    protected $type = 'Base settings and files';

    protected $forced = true;

    public function __construct(Filesystem $filesystem){
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle(){
      $this->changeSettings();
      $this->publishVueComponents();
      $this->publishAssets();
      $this->createRouteFiles();
      $this->info("{$this->type} installed successfully.");
      $this->call('clean:all');
    }

    protected function changeSettings(){
      $settings = $this->getSettings();

      foreach ($settings as $name => $setting) {
        $fullPath = base_path($setting['path']);
        $content = $this->compileContent($fullPath, $setting);
        if ($this->putContent($fullPath, $content)) {
            $this->info("Successfully $name");
        }
      }
    }

    protected function publishVueComponents(){
      $this->call('vendor:publish',[
        '--provider' => 'AdiFaidz\Base\Providers\BaseServiceProvider',
        '--tag'      => 'vue',
      ]);
    }

    protected function publishAssets(){
      $this->call('vendor:publish',[
        '--provider' => 'AdiFaidz\Base\Providers\BaseServiceProvider',
        '--tag'      => 'asset',
      ]);
    }

    protected function createRouteFiles(){
      $this->filesystem->put(config('base.admin_route'), '<?php' . PHP_EOL);
      $this->filesystem->put(config('base.client_route'), '<?php' . PHP_EOL);
    }

    protected function getSettings(){
      return [
        'add guard config' => [
          'path'=> 'config/auth.php',
          'stub'=> __DIR__ . '/stubs/install/addGuardsConfig.stub',
          'search' => "'guards' => [",
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add password config' => [
          'path' => 'config/auth.php',
          'stub' => __DIR__ . '/stubs/install/addPasswordsConfig.stub',
          'search' => "'passwords' => [",
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add middleware group' => [
          'path' => 'app/Http/Kernel.php',
          'search' => 'protected $middlewareGroups = [',
          'stub' => __DIR__ . '/stubs/install/addMiddlewareGroup.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add route middleware' => [
          'path' => 'app/Http/Kernel.php',
          'search' => 'protected $routeMiddleware = [',
          'stub' => __DIR__ . '/stubs/install/addRouteMiddleware.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add import to js file' => [
          'path' => 'resources/assets/js/app.js',
          'search' => "require('./bootstrap');",
          'stub' => __DIR__ . '/stubs/install/addImportJs.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add import to sass file' => [
          'path' => 'resources/assets/sass/app.scss',
          'search' => '@import "node_modules/bootstrap-sass/assets/stylesheets/bootstrap";',
          'stub' => __DIR__ . '/stubs/install/addImportSass.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add import to mix file' => [
          'path' => 'webpack.mix.js',
          'search' => "const { mix } = require('laravel-mix');",
          'stub' => __DIR__ . '/stubs/install/addImportMix.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'add npm package' => [
          'path' => 'package.json',
          'search' => '  "devDependencies": {',
          'stub' => __DIR__ . '/stubs/install/addNpmPackage.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => true,
          'callback' => 'checkPackage',
        ],
        'add vue root method' => [
          'path' => 'resources/assets/js/app.js',
          'search' => "    el: '#app'",
          'stub' => __DIR__ . '/stubs/install/addVueRootMethod.stub',
          'mode' => 'replace',
          'multiline' => false,
          'callback' => null,
        ],
        'change icon path' => [
          'path' => 'resources/assets/sass/_variables.scss',
          'search' => '$icon-font-path: "~bootstrap-sass/assets/fonts/bootstrap/";',
          'stub' => __DIR__ . '/stubs/install/changeIconPath.stub',
          'mode' => 'replace',
          'multiline' => false,
          'callback' => null,
        ],
        'add column to users table' => [
          'path' => 'database/migrations/*_create_users_table.php',
          'search' => '            $table->rememberToken();',
          'stub' => __DIR__ . '/stubs/install/AddColumnToUsersTable.stub',
          'mode' => 'add',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
      ];
    }

    protected function putContent($path, $content){
        if($this->alreadyExists($path) && !$this->forced) {
            $this->error($path . ' already exists!');
            return false;
        }

        $this->makeDirectory($path);
        $this->filesystem->put($path, $content);
        return true;
    }

    protected function compileContent(&$path, $setting){
        $path = $this->filesystem->glob($path)[0];
        $originalContent = $this->filesystem->get($path);
        $content = rtrim($this->filesystem->get($setting['stub']));

        if(!$setting['multiline'])
          return $this->replaceContentWithStub($originalContent, $content, $setting);

        $lines = array_reverse(preg_split("/\r\n|\n|\r/", $content));

        foreach ($lines as $line) {
          if(!empty($line))
            $originalContent = $this->replaceContentWithStub($originalContent, $line, $setting, $setting['callback']);
        }

        return $originalContent;
    }

    protected function replaceContentWithStub($originalContent, $content, $setting, $callback= null){
      $valid = !str_contains(trim($originalContent), trim($content));

      if($valid && $callback !== null){
        $valid = $valid && $this->{$callback}($originalContent,$content);
      }

      if($valid) {
          if($setting['mode'] === "add"){
            if ($setting['prefix']) {
                $stub = $content . PHP_EOL . $setting['search'];
            } else {
                $stub = $setting['search'] . PHP_EOL . $content;
            }
          }
          else if($setting['mode'] === "replace"){
            $stub = $content;
          }

          $originalContent = str_replace($setting['search'], $stub, $originalContent);
      }

      return $originalContent;
    }

    protected function checkPackage($originalContent, &$content){
      $packagename = preg_split('/:/', $content)[0];
      $content .= ",";

      if(str_contains(trim($originalContent), trim($packagename)))
        return false;


      return true;
    }

    protected function alreadyExists($path){
      return $this->filesystem->exists($path);
    }

    protected function makeDirectory($path){
        if (! $this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0777, true, true);
        }
    }

}
