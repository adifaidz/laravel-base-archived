<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class BaseInstallCommand extends Command
{
    protected $signature = 'base:install';

    protected $description = 'Installs base package';

    protected $type = 'Settings';

    protected $forced = true;

    public function __construct(Filesystem $filesystem){
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle(){
      $settings = $this->getSettings();

      foreach ($settings as $name => $setting) {
        $path = $setting['path'];
        $fullPath = base_path() . $path;

        if ($this->putContent($fullPath, $this->compileContent($fullPath, $setting))) {
            $this->info("Successfully registered $name");
        }
      }

      $this->info("{$this->type} installed successfully.");
      $this->call('clean:all');
    }

    protected function getSettings(){
      return [
        'guard config' => [
             'path'=> '/config/auth.php',
             'stub'=> __DIR__ . '/stubs/config/guards.stub',
             'search' => "'guards' => [",
             'prefix' => false,
        ],
        // 'provider config' => [
        //      'path' => '/config/auth.php',
        //      'stub' => __DIR__ . '/stubs/config/providers.stub',
        //      'search' => "'providers' => [",
        //      'prefix' => false,
        // ],
        'password config' => [
             'path' => '/config/auth.php',
             'stub' => __DIR__ . '/stubs/config/passwords.stub',
             'search' => "'passwords' => [",
             'prefix' => false,
        ],
        'middleware group' => [
             'path' => '/app/Http/Kernel.php',
             'search' => 'protected $middlewareGroups = [',
             'stub' => __DIR__ . '/stubs/middleware/middlewareGroup.stub',
             'prefix' => false,
         ],
        'route middleware' => [
             'path' => '/app/Http/Kernel.php',
             'search' => 'protected $routeMiddleware = [',
             'stub' => __DIR__ . '/stubs/middleware/routeMiddleware.stub',
             'prefix' => false,
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

    protected function compileContent($path, $setting){
        $originalContent = $this->filesystem->get($path);
        $content = $this->filesystem->get($setting['stub']);

        if( ! str_contains(trim($originalContent), trim($content))) {
            if ($setting['prefix']) {
                $stub = $content . PHP_EOL . $setting['search'];
            } else {
                $stub = $setting['search'] . PHP_EOL . $content;
            }
            $originalContent = str_replace($setting['search'], $stub, $originalContent);
        }
        return $originalContent;
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
