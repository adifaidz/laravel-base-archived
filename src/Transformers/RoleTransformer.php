<?php

namespace AdiFaidz\Base\Transformers;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\Role;

class RoleTransformer extends Transformer
{
    public function transform($item){
        $permissions = [];

        foreach ($item->permissions as $permission) {
          $permissions[] = [
            'id' => $permission->id,
            'display_name' => $permission->display_name,
          ];
        }

        return [
          'id' => $item->id,
					'name' => $item->name,
					'display_name' => $item->display_name,
					'description' => $item->description,
					'created_at' => $item->created_at,
					'updated_at' => $item->updated_at,
          'permissions' => $permissions,
        ];
    }
}
