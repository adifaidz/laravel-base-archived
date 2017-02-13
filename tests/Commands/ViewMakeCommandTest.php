<?php
namespace AdiFaidz\Base\Tests\Commands;

use AdiFaidz\Base\GeneratorTestCase;

class VieMakeCommandTest extends GeneratorTestCase
{
    protected function callCommand($args)
    {
      $this->artisan('factory:view',[
        'name' => $args['name'],
        '--model' => $this->app->getNamespace() . $args['name'],
      ]);
    }

    public function test_create_basic_view()
    {
        $this->filesystem->put($this->app_path('Post.php'), '');

        $this->files = [
            [
              'name' => 'Post',
              'expected_path'=> [
                  $this->view_path('post/index.blade.php'),
                  $this->view_path('post/create.blade.php'),
                  $this->view_path('post/edit.blade.php'),
                  $this->view_path('post/show.blade.php'),
                  $this->view_path('post/partial/form.blade.php'),
                  $this->asset_path('js/components/post/Detail.vue'),
                  $this->asset_path('js/components/post/Form.vue'),
              ]
            ]
        ];

        $this->folders = [
          $this->view_path('post'),
          $this->asset_path('js/components/post'),
        ];

        $this->processFiles($this->files);

        $this->files = [
            [
              'name' => 'Post',
              'expected_path' =>$this->app_path('Post.php'),
            ],
        ];
    }

    public function test_create_namespace_view()
    {
        $this->filesystem->makeDirectory($this->app_path('Admin'));
        $this->filesystem->put($this->app_path('Admin/Post.php'), '');

        $this->files = [
          [
            'name' => 'Admin\Post',
            'expected_path'=> [
                $this->view_path('admin/post/index.blade.php'),
                $this->view_path('admin/post/create.blade.php'),
                $this->view_path('admin/post/edit.blade.php'),
                $this->view_path('admin/post/show.blade.php'),
                $this->view_path('admin/post/partial/form.blade.php'),
                $this->asset_path('js/components/admin/post/Detail.vue'),
                $this->asset_path('js/components/admin/post/Form.vue'),
            ]
          ]
        ];

        $this->folders = [
          $this->view_path('admin'),
          $this->asset_path('js/components/admin'),
          $this->app_path('Admin'),
        ];

        $this->processFiles($this->files);
    }
}
