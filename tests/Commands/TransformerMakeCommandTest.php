<?php
namespace AdiFaidz\Base\Tests\Commands;

use AdiFaidz\Base\GeneratorTestCase;
use Mockery;

class TransformerMakeCommandTest extends GeneratorTestCase
{
    protected function tearDown(){
      parent::tearDown();

      Mockery::close();
    }

    protected function callCommand($args)
    {
      $this->artisan('base:transformer',[
        'name' => $args['name'],
        '--model' => $args['model'],
      ]);
    }

    public function test_create_basic_transformer()
    {
        $this->mockCommandGetColumns();

        $this->filesystem->put($this->app_path('Post.php'), '');

        $this->files = [
          [
            'name' => 'Post',
            'expected_path' => $this->transformer_path('PostTransformer.php'),
            'model' => 'Post',
          ],
        ];

        $this->folders = [
          $this->transformer_path(),
        ];

        $this->processFiles($this->files);

        $this->files = [
            [
              'name' => 'Post',
              'expected_path' =>$this->app_path('Post.php'),
            ],
        ];
    }

    public function test_create_namespace_transformer()
    {
        $this->mockCommandGetColumns();

        $this->filesystem->makeDirectory($this->app_path('Admin'));
        $this->filesystem->put($this->app_path('Admin/Post.php'), '');

        $this->files = [
          [
            'name' => 'Admin\Post',
            'expected_path' => $this->transformer_path('Admin/PostTransformer.php'),
            'model' => 'Admin\Post',
          ],
        ];

        $this->folders = [
          $this->transformer_path(),
          $this->app_path('Admin'),
        ];

        $this->processFiles($this->files);
    }

    private function mockCommandGetColumns(){
      $command = Mockery::mock('AdiFaidz\Base\Commands\TransformerMakeCommand[getColumns]', [new \Illuminate\Filesystem\Filesystem()]);
      $command->shouldReceive('getColumns')
              ->once()
              ->andReturn([
                 "id",
                 "created_at",
                 "updated_at",
               ]);

      $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);
    }
}
