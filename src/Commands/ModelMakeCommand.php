<?php

namespace AdiFaidz\Base\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as LaravelModelMakeCommand;

class ModelMakeCommand extends LaravelModelMakeCommand
{
  protected $name = 'base:model';

  protected $description = 'Create a new Eloquent model class based on Factory template';

  protected function getStub(){
      return __DIR__.'/stubs/Model.stub';
  }
}
