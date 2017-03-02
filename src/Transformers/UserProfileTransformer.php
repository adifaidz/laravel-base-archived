<?php

namespace AdiFaidz\Base\Transformers;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\BaseUserProfile;

class UserProfileTransformer extends Transformer
{
    public function transform($item){
        $result = $item->toArray();
        $result['dob'] = ($item->dob) ? $item->dob->format('d/m/Y') : null;
        $result['created_at'] = $item->created_at->format('d/m/Y');
        $result['updated_at'] = $item->updated_at->format('d/m/Y');
        return $result;
    }
}
