<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class BaseMakeCommand extends GeneratorCommand
{
    protected $signature = 'base:make';

    protected $description = 'Create bootstrap components for base';

    protected $type = 'Base';

    public function __construct(Filesystem $filesystem){
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle(){
      $viewStubs = $this->filesystem->allFiles($this->getStub());

      foreach ($viewStubs as $stub) {
        $path = str_replace($this->getStub(), app_path(), $stub->getPathName());
        $path = str_replace('.stub', '.php', $path);

        $stubContent = $this->filesystem->get($stub->getPathName());

        $args['stub'] = $this->filesystem->get($stub->getPathName());
        $this->makeDirectory($path);
        $this->filesystem->put($path, $this->buildClass(['stub' => $stubContent]));
      }

      $this->info("{$this->type} created successfully.");
    }

    protected function getStub(){
      return __DIR__ . '/stubs/bootstrap';
    }

    public function buildClass(Array $args){
      $stub = $args['stub'];
      $this->replaceRootNamespace($stub);

      return $stub;
    }

    public function replaceRootNamespace(&$stub){
      $namespace = rtrim($this->laravel->getNamespace(), "\\");
      $stub = str_replace('{{rootnamespace}}', $namespace, $stub);

      return $this;
    }

    protected function getDefaultNamespace($rootNamespace){
      return $rootNamespace;
    }
}
