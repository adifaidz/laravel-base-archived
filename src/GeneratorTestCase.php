<?php
namespace AdiFaidz\Base;

use Orchestra\Testbench\TestCase;
use \Illuminate\Filesystem\Filesystem;
use AdiFaidz\Base\Traits\PathTrait;

abstract class GeneratorTestCase extends TestCase
{
    use PathTrait;

    protected $filesystem;

    // Array of file names with name as key and expected path as value
    protected $files = [];

    // Array of folder paths
    protected $folders = [];

    protected function setUp()
    {
        parent::setUp();

        $this->filesystem = new Filesystem();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql.driver', 'mysql');
        $app['config']->set('database.connections.mysql.database', 'base_testing');
        $app['config']->set('database.connections.mysql.username', 'root');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->deleteFiles();
        $this->deleteFolders();
    }

    protected function processFiles(array $files)
    {
        $allExist = true;

        foreach ($files as $file)
        {
            $this->callCommand($file);

            $expected_path = $file['expected_path'];

            if(is_array($expected_path)){
              foreach ($expected_path as $path) {
                if(!$this->filesystem->exists($path)){
                  $allExist = false;
                  break;
                }
                // TODO: Check file content,
              }

              if(!$allExist)
                break;
            }
            else{
              if(!$this->filesystem->exists($expected_path)){
                $allExist = false;
                break;
              }
              // TODO: Check file content,
            }
        }

        $this->assertTrue($allExist, 'Generated files not matching with expected results');
    }

    protected function deleteFiles(){
        foreach ($this->files as $file) {
            $this->filesystem->delete($file['expected_path']);
        }
    }

    protected function deleteFolders(){
        foreach ($this->folders as $folder) {
            $this->filesystem->deleteDirectory($folder);
        }
    }

    protected function getPackageProviders($app)
    {
        return ['AdiFaidz\Base\Providers\BaseServiceProvider'];
    }
}
