<?php
namespace AdiFaidz\Base\Tests;

use AdiFaidz\Base\GeneratorTestCase;

class TransformerMakeCommandTest extends GeneratorTestCase
{
    protected function callCommand($args)
    {
      $this->artisan('factory:transformer',[
        'name' => $args['name'],
      ]);
    }

    public function test_create_basic_transformer()
    {
        $this->files = [
          [
            'name' => 'Post',
            'expected_path' => $this->transformer_path('PostTransformer.php'),
          ],
        ];

        $this->folders = [
          $this->transformer_path(),
        ];

        $this->processFiles($this->files);
    }

    public function test_create_namespace_transformer()
    {
        $this->files = [
          [
            'name' => 'Admin\Post',
            'expected_path' => $this->transformer_path('Admin/PostTransformer.php'),
          ],
        ];

        $this->folders = [
          $this->transformer_path(),
        ];

        $this->processFiles($this->files);
    }
}
