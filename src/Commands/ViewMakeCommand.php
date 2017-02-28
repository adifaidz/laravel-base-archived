<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ViewMakeCommand extends GeneratorCommand
{
    protected $signature = 'base:view {name} {--m|model=}';

    protected $description = 'Create new CRUD ready views and vue components for a model class';

    protected $type = 'View';

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle()
    {
      $name = $this->getNameInput();
      $viewPath = $this->parseName($name, 'getViewPath', base_path());
      $vuePath = $this->parseName($name, 'getVuePath', base_path());

      $modelClass = $this->option('model');

      if(!$modelClass){
        return $this->error("Model class is required.");
      }

      $model = $this->parseName($modelClass, 'getDefaultNamespace');

      if(!$this->filesystem->exists($this->getPath($model))){
        return $this->error("Model $modelClass does not exists.");
      }

      $args = [
       'name'=> trim($this->argument('name')),
       'model'=> $model,
      ];

      $viewStubs = $this->filesystem->allFiles($this->getViewStubs());
      $vueStubs = $this->filesystem->allFiles($this->getVueStubs());

      foreach ($viewStubs as $stub) {
        $stubPath = str_replace($this->getViewStubs(), '', $stub->getPathName());
        $stubPath = str_replace('.stub', '.php', $stubPath);

        $path = $viewPath .$stubPath;
        $filename = str_replace("\\", '', $stubPath);

        if($this->filesystem->exists($path)){
          $this->info("View $filename already exists");
          continue;
        }

        $args['stub'] = $this->filesystem->get($stub->getPathName());
        $this->makeDirectory($path);
        $this->filesystem->put($path, $this->buildClass($args));
        unset($args['stub']);
      }

      foreach ($vueStubs as $stub) {
        $stubPath = str_replace($this->getVueStubs(), '', $stub->getPathName());
        $stubPath = str_replace('.stub', '.vue', $stubPath);

        $path = $vuePath .$stubPath;
        $filename = str_replace("\\", '', $stubPath);

        if($this->filesystem->exists($path)){
          $this->info("Vue component $filename already exists");
          continue;
        }

        $args['stub'] = $this->filesystem->get($stub->getPathName());
        $this->makeDirectory($path);
        $this->filesystem->put($path, $this->buildClass($args));
        unset($args['stub']);
      }

      //Disable appending to app.js for now

      //$this->appendAppJs($name, $args);
      $this->info("{$this->type} created successfully.");
    }

    protected function getStub(){

    }

    protected function getViewStubs()
    {
        return !empty(config('base.stubs.view')) ? config('base.stubs.view') : __DIR__ . '/stubs/view/views';
    }

    protected function getVueStubs()
    {
        return !empty(config('base.stubs.vue')) ? config('base.stubs.vue') : __DIR__ . '/stubs/view/vue';
    }

    protected function getViewPath($rootNamespace)
    {
      return $rootNamespace . '\resources\views';
    }

    protected function getVuePath($rootNamespace)
    {
      return $rootNamespace . '\resources\assets\js\components';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
      return $rootNamespace;
    }

    protected function get($rootNamespace)
    {
      return $rootNamespace . '\Transformers';
    }

    public function buildClass(Array $args)
    {
      $stub = $args['stub'];
      $this->replaceModel($stub, $args['model'])
           ->replaceName($stub, $args['name']);

      return $stub;
    }

    public function getNameInput(){
      return strtolower(trim($this->argument('name')));
    }

    public function replaceModel(&$stub, $model){
      $modelpos = 0;

      if(strrpos($model, '\\') !== 0){
        $modelpos = strrpos($model, '\\') + 1;
      }

      $class = ucfirst(substr($model, $modelpos));
      $stub = str_replace('{{modelclass}}', $class, $stub);

      $human = preg_replace('/(?<!\ )[A-Z]/', '$0', $class);
      $stub = str_replace('{{modelhuman}}', $human, $stub);

      $varname  = strtolower($class);
      $stub = str_replace('{{modelname}}', $varname, $stub);

      return $this;
    }

    public function replaceName(&$stub, $name){
      $lastSlashPos = 0;

      if(strrpos($name, '\\') !== 0){
        $lastSlashPos = strrpos($name, '\\');
      }

      $classLength = strlen(substr($name, $lastSlashPos));
      $layoutPath = substr($name, -($lastSlashPos + $classLength),  strlen($name) - $classLength);

      $type = str_replace('\\', '.', strtolower($layoutPath));
      $stub = str_replace('{{type}}', "$type", $stub);

      $viewpath  = str_replace('\\', '.', strtolower($name));
      $stub = str_replace('{{viewpath}}', "$viewpath", $stub);

      $vuepath   = str_replace('\\', '-', strtolower($name));
      $stub = str_replace('{{vuepath}}', "$vuepath", $stub);

      return $this;
    }

    public function appendAppJs($name, $args){
      $filePath = base_path() .'\resources\assets\js\app.js';
      $stubPath = __DIR__ . '/../stubs/app.js.stub';

      $linecount = 0;
      $handle = fopen($filePath, "r");
      while(!feof($handle)){
        $line = fgets($handle);

        if(substr_count($line, "const app = new Vue({") !== 0){
          break;
        }
        $linecount++;
      }
      fclose($handle);

      $stublines = file( $stubPath , FILE_IGNORE_NEW_LINES );
      $vuepath  = str_replace('\\', '-', strtolower($name));
      $vuefilepath  = str_replace('\\', '/', strtolower($name));

      foreach ($stublines as &$stub) {
        $stub = str_replace('{{vuepath}}', $vuepath, $stub);
        $stub = str_replace('{{vuefilepath}}',$vuefilepath , $stub);
      }

      $lines = file( $filePath , FILE_IGNORE_NEW_LINES );
      $searchline = $lines[$linecount];
      array_splice($lines, $linecount-1, 0, $stublines);
      file_put_contents($filePath, join("\n", $lines));
    }
}
