<?php
return [
  'name' => 'CHART',
  'logo' => '<i class="fa fa-bell-o" aria-hidden="true"></i>',
  'users' => [
    'model' => 'AdiFaidz\Base\User'
  ],
  'roles' => [
    'model' => 'AdiFaidz\Base\Role'
  ],
  'permissions' => [
    'model' => 'AdiFaidz\Base\Permission'
  ],
  'userprofiles' => [
    'model' => 'AdiFaidz\Base\UserProfile'
  ],
  'stub' => [
    'index' => null,
    'show' => null,
    'create' => null,
    'edit' => null,
    'form' => null,
  ],
  'dev_env' => 'local',
  'prod_env' => 'production',

];
