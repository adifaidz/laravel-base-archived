<?php
namespace AdiFaidz\Base\Traits;

trait PathTrait
{
  protected function app_path(string $path = '') : string
  {
      return $this->app->path() . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function base_path(string $path = '') : string
  {
      return $this->app->basepath() . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function resource_path(string $path = '') : string
  {
      return $this->app->resourcePath() . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function asset_path(string $path = '') : string
  {
      return $this->app->resourcePath() . DIRECTORY_SEPARATOR . 'assets' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function view_path(string $path = '') : string
  {
      return $this->app->resourcePath() . DIRECTORY_SEPARATOR . 'views' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function public_path(string $path = '') : string
  {
      return $this->app->publicPath() . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function database_path(string $path = '') : string
  {
      return $this->app->databasePath() . ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function controller_path(string $path = '') : string
  {
      return $this->app->path() . DIRECTORY_SEPARATOR . 'Http/Controllers'. ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }

  protected function transformer_path(string $path = '') : string
  {
      return $this->app->path() . DIRECTORY_SEPARATOR . 'Transformers'. ($path ? DIRECTORY_SEPARATOR.$path : $path);
  }
}
