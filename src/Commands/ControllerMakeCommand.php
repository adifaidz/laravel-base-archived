<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ControllerMakeCommand extends GeneratorCommand
{
    protected $signature = 'factory:controller {name} {--m|model=}';

    protected $description = 'Create a new controller class based on Factory template';

    protected $type = 'Controller';

    public function __construct(Filesystem $filesystem){
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle(){
      $name = $this->parseName($this->getNameInput());

      if ($this->filesystem->exists($path = $this->getPath($name))) {
        return $this->error($this->getNameInput() . ' already exists!');
      }

      $model = $this->option('model');

      if(!$model){
        return $this->error("Model class is required.");
      }

      $model = $this->parseName($model, 'getModelNamespace');

      if(!$this->filesystem->exists($this->getPath($model))){
        return $this->error("Model $model does not exists.");
      }

      $transformer = $this->parseName($this->argument('name') . 'Transformer', 'getTransformerNamespace');

      $args = [
       'name'=> $name,
       'model'=> $model,
       'transformer' => $transformer,
      ];

      $this->makeDirectory($path);
      $this->filesystem->put($path, $this->buildClass($args));
      $this->info("{$this->type} created successfully.");
    }

    protected function getStub(){
        return $this->filesystem->get(__DIR__ . '/stubs/Controller.stub');
    }

    protected function getDefaultNamespace($rootNamespace){
      return $rootNamespace . '\Http\Controllers';
    }

    protected function getModelNamespace($rootNamespace){
      return $rootNamespace;
    }

    protected function getTransformerNamespace($rootNamespace){
      return $rootNamespace . '\Transformers';
    }

    public function buildClass(Array $args){
      $stub = parent::buildClass($args);

      $this->replaceModel($stub, $args['model'])
           ->replaceTransformerNamespace($stub, $args['transformer']);

      return $stub;
    }

    protected function replaceModel(&$stub, $modelNamespace){
        $modelClass = substr($modelNamespace, strrpos($modelNamespace, '\\') + 1);

        $modelName  = strtolower($modelClass);

        $viewpath  = str_replace('\\', '.', strtolower($this->argument('name')));

        $stub = str_replace('{{modelclass}}', "$modelClass", $stub);

        $stub = str_replace('{{modelname}}', "$modelName", $stub);

        $stub = str_replace('{{viewpath}}', "$viewpath", $stub);

        $stub = str_replace('{{modelnamespace}}', "$modelNamespace", $stub);
        return $this;
    }

    protected function replaceTransformerNamespace(&$stub, $transformer){
        $stub = str_replace('{{transformernamespace}}', "$transformer", $stub);
        return $this;
    }
}
