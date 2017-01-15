<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ResourceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:resource {name} {{--t|type=client}} {{--m|migrate}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new full CRUD ready components based on specified model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      app()['composer']->dumpAutoLoads();
      $name = $this->argument('name');
      $type = $this->option('type');

      if($type != "admin" && $type != "client"){
        return $this->error('Type not supported');
      }

      $this->callModelMakeCommand($name);
      $this->callMigrateCommand();
      $this->callApiControllerMakeCommand($name);
      $this->callControllerMakeCommand($name);
      $this->callPaginatorMakeCommand($name);
      $this->callViewMakeCommand($name);
      $this->appendApiRoute($name);
      $this->appendWebRoute($name);
      $this->callMigrateRollbackCommand();
      echo exec('gulp');
    }

    public function callModelMakeCommand($name)
    {
      $this->call('factory:model',[
        'name' => $name,
        '-m' => true,
      ]);
    }

    public function callMigrateCommand()
    {
      $this->call('migrate');
    }

    public function callControllerMakeCommand($name)
    {
      $this->call('factory:controller',[
        'name' => ucfirst($this->option('type')) . '\\' .ucfirst($name),
        '-m' => $name,
      ]);
    }

    public function callPaginatorMakeCommand($name)
    {
      $this->call('factory:paginator',[
        'name' => $name,
        '-m' => $name,
        '-t' => true,
      ]);
    }

    public function callViewMakeCommand($name)
    {
      $this->call('factory:view',[
        'name' => ucfirst($this->option('type')) . '\\' . ucfirst($name),
        '-m' => $name,
      ]);
    }

    public function callApiControllerMakeCommand($name)
    {
      $this->call('factory:apicontroller',[
        'name' => $name,
        '-m' => $name,
      ]);
    }

    public function appendApiRoute($name){
      $namespace =$this->parseName($name);

      $stub = file_get_contents(__DIR__.'/stubs/apiRoutes.stub');
      $stub = str_replace('{{modelname}}', strtolower($name), $stub);
      $stub = str_replace('{{model}}', ucwords($name), $stub);
      $stub = str_replace('{{modelnamespace}}', $namespace, $stub);

      $dest = "routes/api.php";
      $find = str_replace('\\', '\\\\\\\\', $namespace);

      if(exec('grep '. escapeshellarg("//Routes for $find") . " $dest")){
        $this->info('Api route already added');
        return;
      }

      file_put_contents(
          base_path($dest),
          $stub,
          FILE_APPEND
      );
    }

    public function appendWebRoute($name){
      $namespace =$this->parseName($name);
      $type = $this->option('type');

      $stub = file_get_contents(__DIR__.'/stubs/webRoutes.stub');
      $stub = str_replace('{{modelname}}', strtolower($name), $stub);
      $stub = str_replace('{{routeurl}}', strtolower($name), $stub);
      $stub = str_replace('{{routename}}', strtolower($type) . '.' . strtolower($name), $stub);
      $stub = str_replace('{{controller}}', ucfirst($type) . '\\' . ucfirst($name), $stub);
      $stub = str_replace('{{type}}', strtolower($type), $stub);
      $stub = str_replace('{{modelnamespace}}', $namespace, $stub);

      $dest = "routes/web/{$this->option('type')}.php";
      $find = str_replace('\\', '\\\\\\\\', $namespace);

      if(exec('grep '. escapeshellarg("//Routes for $find") . " $dest")){
        $this->info('Web route already added');
        return;
      }

      file_put_contents(
          base_path($dest),
          $stub,
          FILE_APPEND
      );
    }

    public function callMigrateRollbackCommand()
    {
      $migrate = $this->option('migrate');
      if(!$migrate)
        $this->call('migrate:rollback');
    }

    private function getDefaultNamespace($rootNamespace){
      return $rootNamespace;
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
}
