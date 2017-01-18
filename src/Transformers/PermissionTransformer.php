<?php

namespace AdiFaidz\Base\Transformers;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\Permission;

class PermissionTransformer extends Transformer
{
    public function transform($item){
        return [
          'id' => $item->id,
					'name' => $item->name,
					'display_name' => $item->display_name,
					'description' => $item->description,
					'created_at' => $item->created_at,
					'updated_at' => $item->updated_at,

        ];
    }
}
