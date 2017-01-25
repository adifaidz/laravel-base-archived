<?php

namespace AdiFaidz\Base\Transformers;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\BaseUserProfile;

class UserProfileTransformer extends Transformer
{
    public function transform($item){
        return [
          'id' => $item->id,
          'first_name' => $item->first_name,
          'last_name'  => $item->last_name,
          'ic'         => $item->ic,
          'address'    => $item->address,
          'dob'        => ($item->dob) ? $item->dob->format('d/m/Y') : null,
					'created_at' => $item->created_at->format('d/m/Y'),
					'updated_at' => $item->updated_at->format('d/m/Y'),

        ];
    }
}
