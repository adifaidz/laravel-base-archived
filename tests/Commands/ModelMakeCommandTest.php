<?php
namespace AdiFaidz\Base\Tests\Commands;

use AdiFaidz\Base\GeneratorTestCase;

class ModelMakeCommandTest extends GeneratorTestCase
{
    protected function callCommand($args)
    {
      $this->artisan('factory:model',[
        'name' => $args['name'],
      ]);
    }

    public function test_create_basic_model()
  	{
        $this->files = [
            [
              'name' => 'Post',
              'expected_path' => $this->app_path('Post.php'),
            ],
        ];

        $this->processFiles($this->files);
  	}

    public function test_create_namespace_model()
    {
        $this->files = [
          [
            'name' => 'Admin\Post',
            'expected_path' => $this->app_path('Admin/Post.php'),
          ],
        ];

        $this->folders = [
          $this->app_path('Admin'),
        ];

        $this->processFiles($this->files);
    }

}
