<?php

namespace Chart\Console\Commands;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class GeneratorCommand extends Command
{
    use AppNamespaceDetectorTrait;

    protected $filesystem;

    protected $type;

    protected abstract function getStub();
    protected abstract function getDefaultNamespace($rootNamespace);

    public function buildClass(Array $args)
    {
      $stub = $this->getStub();

      $this->replaceClassNamespace($stub, $args['name'])
           ->replaceRootNamespace($stub)
           ->replaceClassName($stub, $args['name']);

      return $stub;
    }

    protected function replaceClassNamespace(&$stub, $name)
    {
        $namespace = $this->getNamespace($name);
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        return $this;
    }

    protected function replaceRootNamespace(&$stub){
        $namespace = $this->laravel->getNamespace();
        $stub = str_replace('{{rootnamespace}}', $namespace, $stub);
        return $this;
    }

    protected function replaceClassName(&$stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $stub = str_replace('{{class}}', $class, $stub);
        return $this;
    }

    protected function parseName($name, $namespaceMethod= 'getDefaultNamespace', $rootNamespace = null)
    {
        if($rootNamespace === null)
          $rootNamespace = $this->laravel->getNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->{$namespaceMethod}(trim($rootNamespace, '\\')).'\\'.$name, $namespaceMethod, $rootNamespace);
    }

    protected function makeDirectory($path)
    {
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    protected function getPath($name)
    {
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(){
      $name = trim($this->argument('name'));
      $name =  ends_with($name, $this->type) ?
              $name :
              $name . $this->type;

      return ucwords(camel_case($name));
    }
}
