<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class BaseGuardInstallCommand extends Command
{
    protected $signature = 'base:settings-install';

    protected $description = 'Add appropriate settings for base to work';

    protected $type = 'Settings';

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle()
    {
      $settings = $this->getSettings();

      foreach ($settings as $name => $setting) {
        $path = $setting['path'];
        $fullPath = base_path() . $path;

        if ($this->putContent($fullPath, $this->compileContent($fullPath, $setting))) {
            $this->info("Successfully registered $name");
        }
      }

      $this->info("{$this->type} installed successfully.");
    }

    protected function getSettings(){
      return [
        'guard config' => [
             'path'=> '/config/auth.php',
             'stub'=> __DIR__ . '/stubs/config/guards.stub',
             'search' => "'guards' => [",
             'prefix' => false,
        ],
        'provider config' => [
             'path' => '/config/auth.php',
             'stub' => __DIR__ . '/stubs/config/providers.stub',
             'search' => "'providers' => [",
             'prefix' => false,
        ],
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

    protected function putContent($path, $content)
    {
        if($this->alreadyExists($path)) {
            $this->error($path . ' already exists!');
            return false;
        }
        $this->makeDirectory($path);
        $this->filesystem->put($path, $content);
        return true;
    }

    protected function compileContent($path, $setting) //It should be compile method instead
    {
        $originalContent = $this->filesystem->get($path);
        $content = $this->filesystem->get($setting['stub']);

        if( ! str_contains(trim($originalContent), trim($content))) {
            if ($setting['prefix']) {
                $stub = $content . $setting['search'];
            } else {
                $stub = $setting['search'] . $content;
            }
            $originalContent = str_replace($setting['search'], $stub, $originalContent);
        }
        return $originalContent;
    }

    protected function alreadyExists($path)
    {
      return $this->filesystem->exists($path);
    }

    protected function makeDirectory($path)
    {
        if (! $this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0777, true, true);
        }
    }

}
