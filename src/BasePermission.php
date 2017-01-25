<?php

namespace AdiFaidz\Base;

use Laratrust\LaratrustPermission;
use AdiFaidz\Base\Traits\TableInfoTrait;

class BasePermission extends LaratrustPermission
{
    use TableInfoTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('basetrust.permissions_table');
    }
}
