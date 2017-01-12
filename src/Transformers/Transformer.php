<?php

namespace AdiFaidz\Base\Transformers;

abstract class Transformer
{
    protected $columns = [];

    public function transformCollection(array $items)
    {
      return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}
