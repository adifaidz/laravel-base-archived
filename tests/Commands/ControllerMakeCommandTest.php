<?php
namespace AdiFaidz\Base\Tests\Commands;

use AdiFaidz\Base\GeneratorTestCase;

class ControllerMakeCommandTest extends GeneratorTestCase
{
    protected function callCommand($args)
    {
      $this->artisan('base:controller',[
        'name' => $args['name'],
        '--model' => $args['model'],
      ]);
    }

    public function test_create_basic_controller()
    {
        $this->filesystem->put($this->app_path('Post.php'), '');

        $this->files = [
            [
              'name' => 'Post',
              'expected_path' => $this->controller_path('PostController.php'),
              'model' => 'Post',
            ],
        ];

        $this->folders = [
          $this->app_path('Http'),
        ];

        $this->processFiles($this->files);

        $this->files = [
            [
              'name' => 'Post',
              'expected_path' =>$this->app_path('Post.php'),
            ],
        ];
    }

    public function test_create_namespace_controller()
    {
        $this->filesystem->makeDirectory($this->app_path('Admin'));
        $this->filesystem->put($this->app_path('Admin/Post.php'), '');

        $this->files = [
            [
              'name' => 'Admin\Post',
              'expected_path' => $this->controller_path('Admin/PostController.php'),
              'model' => 'Admin\Post',
            ],
        ];

        $this->folders = [
          $this->app_path('Http'),
          $this->app_path('Admin'),
        ];

        $this->processFiles($this->files);
    }
}
