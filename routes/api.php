<?php
//Routes for AdiFaidz\Base\Role

$this->router->get('/role', [
  'as' => 'api.role',
  'uses' => 'Api\RoleController@role',
]);

//Routes for AdiFaidz\Base\Permission

$this->router->get('/permission', [
  'as' => 'api.permission',
  'uses' => 'Api\PermissionController@permission',
]);

//Routes for AdiFaidz\Base\BaseUser

$this->router->get('/user', [
  'as' => 'api.user',
  'uses' => 'Api\UserController@user',
]);

//Routes for AdiFaidz\Base\BaseUserProfile

$this->router->get('/userprofile', [
  'as' => 'api.userprofile',
  'uses' => 'Api\UserProfileController@userprofile',
]);
