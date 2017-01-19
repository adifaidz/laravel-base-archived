<?php

namespace AdiFaidz\Base;

use Laratrust\LaratrustPermission;
use AdiFaidz\Base\Traits\TableInfoTrait;

class BasePermission extends LaratrustPermission
{
    use TableInfoTrait;
}
