<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ViewMakeCommand extends GeneratorCommand
{
    protected $signature = 'base:install';

    protected $description = 'Create new CRUD ready views and vue components for a model class';

    protected $type = 'Base';

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle()
    {
      $name = $this->getNameInput();

      $viewStubs = $this->filesystem->allFiles($this->getViewStubs());

      foreach ($viewStubs as $stub) {
        $path = str_replace($this->getStub(), app_path(), $stub->getPathName());
        $path = str_replace('.stub', '.php', $path);

        $args['stub'] = $this->filesystem->get($stub->getPathName());
        $this->makeDirectory($path);
        $this->filesystem->put($path, $this->buildClass(['stub' => $stub]));
      }

      $this->appendAppJs($name, $args);
      $this->info("{$this->type} created successfully.");
    }

    protected function getStub(){
      return __DIR__ . '/stubs/bootstrap';
    }

    public function buildClass(Array $args)
    {
      $stub = $args['stub'];
      $this->replaceNamespace($stub);

      return $stub;
    }

    public function replaceNamespace(&$stub)
    {
      $stub = str_replace($this->laravel->getNamespace(), '{{rootnamespace}}', $stub);

      return $this;
    }
}
