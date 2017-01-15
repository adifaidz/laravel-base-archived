<?php
return [
  'name' => 'CHART',

  'logo' => '<i class="fa fa-bell-o" aria-hidden="true"></i>',

  'users' => [
    'model' => 'Chart\User'
  ],

  'roles' => [
    'model' => 'Chart\Role'
  ],

  'permissions' => [
    'model' => 'Chart\Permission'
  ],

  'userprofiles' => [
    'model' => 'Chart\UserProfile'
  ],

  'stub' => [
    'index' => null,
    'show' => null,
    'create' => null,
    'edit' => null,
    'form' => null,
  ],

  'route' => [
    'web' => [
        'admin' => null,
        'web' => null,
      ]
  ],
  'dev_env' => 'local',

  'prod_env' => 'production'

];
