<?php

namespace AdiFaidz\Base;

use Laratrust\LaratrustPermission;
use AdiFaidz\Base\Traits\TableInfoTrait;

class BasePermission extends LaratrustPermission
{
    use TableInfoTrait;

    public function __construct(){
      $this->table = config('basetrust.permissions_table');
    }
}
