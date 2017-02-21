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
      $this->info("{$this->type} installed successfully.");
      $this->call('clean:all');
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

    protected function changeSettings(){
      $settings = $this->getSettings();

      foreach ($settings as $name => $setting) {
        $path = $setting['path'];
        $fullPath = base_path() . $path;

        if ($this->putContent($fullPath, $this->compileContent($fullPath, $setting))) {
            $this->info("Successfully registered $name");
        }
      }
    }

    protected function getSettings(){
      return [
        'guard config' => [
          'path'=> '/config/auth.php',
          'stub'=> __DIR__ . '/stubs/config/guards.stub',
          'search' => "'guards' => [",
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'password config' => [
          'path' => '/config/auth.php',
          'stub' => __DIR__ . '/stubs/config/passwords.stub',
          'search' => "'passwords' => [",
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'middleware group' => [
          'path' => '/app/Http/Kernel.php',
          'search' => 'protected $middlewareGroups = [',
          'stub' => __DIR__ . '/stubs/middleware/middlewareGroup.stub',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'route middleware' => [
          'path' => '/app/Http/Kernel.php',
          'search' => 'protected $routeMiddleware = [',
          'stub' => __DIR__ . '/stubs/middleware/routeMiddleware.stub',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'javascript bundle' => [
          'path' => '/resources/assets/js/app.js',
          'search' => "require('./bootstrap');",
          'stub' => __DIR__ . '/stubs/assets/js.stub',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'css bundle' => [
          'path' => '/resources/assets/sass/app.scss',
          'search' => '@import "node_modules/bootstrap-sass/assets/stylesheets/bootstrap";',
          'stub' => __DIR__ . '/stubs/assets/scss.stub',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'webpack.mix' => [
          'path' => '/webpack.mix.js',
          'search' => "const { mix } = require('laravel-mix');",
          'stub' => __DIR__ . '/stubs/assets/mix.stub',
          'prefix' => false,
          'multiline' => false,
          'callback' => null,
        ],
        'package.json' => [
          'path' => '/package.json',
          'search' => '  "devDependencies": {',
          'stub' => __DIR__ . '/stubs/assets/package.stub',
          'prefix' => false,
          'multiline' => true,
          'callback' => 'checkPackage',
        ]
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

    protected function compileContent($path, $setting){
        $originalContent = $this->filesystem->get($path);
        $content = $this->filesystem->get($setting['stub']);

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

      if($callback !== null){
        $valid = $valid && $this->{$callback}($originalContent,$content);
      }

      if($valid) {

          if ($setting['prefix']) {
              $stub = $content . PHP_EOL . $setting['search'];
          } else {
              $stub = $setting['search'] . PHP_EOL . $content;
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
