<?php

namespace AdiFaidz\Base\Transformers;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\BasePermission;

class PermissionTransformer extends Transformer
{
    public function transform($item){
        return $item->toArray();
    }
}
