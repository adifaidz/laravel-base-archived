<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class ResourceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base:resource {name} {{--t|type=client}} {{--m|migrate}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new full CRUD ready components based on specified model';

    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem){
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        app()['composer']->dumpAutoLoads();
        $name = $this->argument('name');
        $type = $this->option('type');

        if($type != "admin" && $type != "client"){
          return $this->error('Type not supported');
        }

        if (!$this->alreadyExists($name)){
          return $this->error("Model $name does not exists!");
        }

        $this->callMigrateCommand();
        $this->callApiControllerMakeCommand($name);
        $this->callControllerMakeCommand($name);
        $this->callPaginatorMakeCommand($name);
        $this->callTransformerMakeCommand($name);
        $this->callViewMakeCommand($name);
        $this->appendApiRoute($name);
        $this->appendWebRoute($name);

        echo exec('npm run dev');
    }

    public function callMigrateCommand(){
        $this->call('migrate');
    }

    public function callControllerMakeCommand($name){
        $this->call('base:controller',[
          'name' => ucfirst($this->option('type')) . '\\' .ucfirst($name),
          '-m' => $name,
        ]);
    }

    public function callPaginatorMakeCommand($name){
        $this->call('base:paginator',[
          'name' => ucfirst($this->option('type')) . '\\' .ucfirst($name),
          '-m' => $name,
        ]);
    }

    public function callTransformerMakeCommand($name){
        $this->call('base:transformer',[
          'name' => ucfirst($this->option('type')) . '\\' .ucfirst($name),
          '-m' => $name,
        ]);
    }

    public function callViewMakeCommand($name){
        $this->call('base:view',[
          'name' => ucfirst($this->option('type')) . '\\' . ucfirst($name),
          '-m' => $name,
        ]);
    }

    public function callApiControllerMakeCommand($name){
        $this->call('base:apicontroller',[
          'name' => ucfirst($this->option('type')) . '\\' . ucfirst($name),
          '-m' => $name,
        ]);
    }

    public function appendApiRoute($name){
        $modelpos = 0;

        if(strrpos($model, '\\') !== 0){
          $modelpos = strrpos($name, '\\') + 1;
        }

        $type = $this->option('type');
        $path = base_path("routes/api.php");
        $namespace =$this->parseName($name);
        $routeName = str_replace('\\', '.', strtolower($name));
        $class = strtolower(substr($model, $modelpos));

        $stub = $this->filesystem->get(__DIR__.'/stubs/apiRoutes.stub');
        $stub = str_replace('{{type}}', $type, $stub);
        $stub = str_replace('{{routename}}', $routeName , $stub);
        $stub = str_replace('{{modelname}}', $class, $stub);
        $stub = str_replace('{{model}}', ucfirst($type) . '\\' . ucfirst($name), $stub);

        if(!$this->filesystem->exists($path)){
            $this->makeDirectory($path);
            $this->filesystem->put($path, '<?php' . PHP_EOL);
        }
        else{
          $routeFile = $this->filesystem->get($path);

          if(str_contains(trim($routeFile), trim($stub))){
              $this->info('Api route already added');
              return;
          }
        }

        $this->filesystem->append($path, $stub);
    }

    public function appendWebRoute($name){

        $type = $this->option('type');
        $path = $type === "client" ? config('base.client_route') : config('base.admin_route');
        $namespace =$this->parseName($name);

        $stub = $this->filesystem->get(__DIR__.'/stubs/webRoutes.stub');
        $stub = str_replace('{{modelname}}', strtolower($name), $stub);
        $stub = str_replace('{{routeurl}}', strtolower($name), $stub);
        $stub = str_replace('{{routename}}', strtolower($type) . '.' . strtolower($name), $stub);
        $stub = str_replace('{{controller}}', ucfirst($type) . '\\' . ucfirst($name), $stub);
        $stub = str_replace('{{type}}', strtolower($type), $stub);
        $stub = str_replace('{{modelnamespace}}', $namespace, $stub);

        if(!$this->filesystem->exists($path)){
            $this->makeDirectory($path);
            $this->filesystem->put($path, '<?php' . PHP_EOL);
        }
        else{
          $routeFile = $this->filesystem->get($path);

          if(str_contains(trim($routeFile), trim($stub))){
              $this->info('Web route already added');
              return;
          }
        }


        $this->filesystem->append($path, $stub);
    }

    protected function parseName($name, $namespaceMethod= 'getDefaultNamespace', $rootNamespace = null){
        if($rootNamespace === null)
          $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->{$namespaceMethod}(trim($rootNamespace, '\\')).'\\'.$name, $namespaceMethod, $rootNamespace);
    }

    private function getDefaultNamespace($rootNamespace){
        return $rootNamespace;
    }

    protected function rootNamespace(){
        return $this->laravel->getNamespace();
    }

    protected function alreadyExists($rawName){
        return $this->filesystem->exists($this->getPath($this->parseName($rawName)));
    }

    protected function getPath($name){
        $name = str_replace_first($this->rootNamespace(), '', $name);
        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function makeDirectory($path){
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0777, true, true);
        }
    }
}
