<?php
//Routes for AdiFaidz\Base\Role

$this->router->get('/admin/role', [
  'as' => 'api.admin.role',
  'uses' => 'Api\Admin\RoleController@role',
]);

//Routes for AdiFaidz\Base\Permission

$this->router->get('/admin/permission', [
  'as' => 'api.admin.permission',
  'uses' => 'Api\AdminPermissionController@permission',
]);

//Routes for AdiFaidz\Base\BaseUser

$this->router->get('/admin/user', [
  'as' => 'api.admin.user',
  'uses' => 'Api\AdminUserController@user',
]);
