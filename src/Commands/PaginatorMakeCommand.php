<?php

namespace AdiFaidz\Base\Commands;

use AdiFaidz\Base\Commands\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class PaginatorMakeCommand extends GeneratorCommand
{
    protected $signature = 'factory:paginator {name} {--m|model=} {--t|transform}';

    protected $description = 'Create a new paginator class that uses json transformer';

    protected $type='Paginator';


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

      $args = [
       'name'=> $name,
       'model'=> $model,
      ];

      $this->makeDirectory($path);
      $this->filesystem->put($path, $this->buildClass($args));
      $this->info("{$this->type} created successfully.");

      $transform = $this->option('transform');

      if($transform)
      {
        $this->call('factory:transformer', [
          'name' => str_replace('Paginator', '', $this->getNameInput()),
          '-m' => $model
        ]);
      }
    }

    protected function getStub(){
      return $this->filesystem->get(__DIR__ . '/stubs/Paginator.stub');
    }

    protected function getDefaultNamespace($rootNamespace){
      return $rootNamespace . '\Paginators';
    }

    protected function getModelNamespace($rootNamespace){
      return $rootNamespace;
    }

    public function buildClass(Array $args){
      $stub = parent::buildClass($args);

      $this->replaceModel($stub, $args['model'])
           ->replaceQuery($stub, $args['model']);

      return $stub;
    }

    protected function replaceModel(&$stub, $model){
        $stub = str_replace('{{model}}', $model, $stub);
        return $this;
    }

    protected function replaceQuery(&$stub, $model){
        $columns = $model::getColumns();

        $query = "->where('{$columns[0]}', 'like', \$value)";
        array_shift($columns);

        foreach ($columns as $column) {
          $query .= "\n\t\t\t\t->orWhere('{$column}', 'like', \$value)";
        }

        $stub = str_replace('{{query}}', $query, $stub);
        return $this;
    }
}
