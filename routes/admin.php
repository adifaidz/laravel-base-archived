<?php

$this->router->post('logout', [
  'as' => 'admin.logout',
  'uses'=> 'Admin\Auth\LoginController@logout',
]);

$this->router->get('dashboard', [
  'as' => 'admin.home',
  'uses' => 'Admin\HomeController@index',
]);

//Routes for AdiFaidz\Base\Role

$this->router->bind('role', function ($value){
  try {
    return \AdiFaidz\Base\BaseRole::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->resource('role', 'Admin\RoleController', ['except' => ['edit','show'], 'as' => 'admin']);

$this->router->group(['prefix' => 'role'], function () {

  $this->router->get('/edit/{role}', [
    'as' => 'admin.role.edit',
    'uses' => 'Admin\RoleController@edit',
  ]);

  $this->router->get('/show/{role}', [
    'as' => 'admin.role.show',
    'uses' => 'Admin\RoleController@show',
  ]);
});

//Routes for AdiFaidz\Base\Permission

$this->router->bind('permission', function ($value){
  try {
    return \AdiFaidz\Base\Permission::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->resource('permission', 'Admin\PermissionController', ['except' => ['edit','show'], 'as' => 'admin']);

$this->router->group(['prefix' => 'permission'], function () {

  $this->router->get('/edit/{permission}', [
    'as' => 'admin.permission.edit',
    'uses' => 'Admin\PermissionController@edit',
  ]);

  $this->router->get('/show/{permission}', [
    'as' => 'admin.permission.show',
    'uses' => 'Admin\PermissionController@show',
  ]);
});

//Routes for AdiFaidz\Base\BaseUser

$this->router->bind('user', function ($value){
  try {
    return \AdiFaidz\Base\BaseUser::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->resource('user', 'Admin\UserController', ['except' => ['edit','show'], 'as' => 'admin']);

$this->router->group(['prefix' => 'user'], function () {

  $this->router->get('/edit/{user}', [
    'as' => 'admin.user.edit',
    'uses' => 'Admin\UserController@edit',
  ]);

  $this->router->get('/show/{user}', [
    'as' => 'admin.user.show',
    'uses' => 'Admin\UserController@show',
  ]);
});

//Routes for AdiFaidz\Base\BaseUserProfile

$this->router->bind('userprofile', function ($value){
  try {
    return \AdiFaidz\Base\BaseUserProfile::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->group(['prefix' => 'userprofile'], function () {

  $this->router->get('/edit/{userprofile}', [
    'as' => 'admin.userprofile.edit',
    'uses' => 'Admin\UserProfileController@edit',
  ]);

  $this->router->put('{userprofile}', [
    'as' => 'admin.userprofile.update',
    'uses' => 'Admin\UserProfileController@update',
  ]);

  $this->router->get('/show/{userprofile}', [
    'as' => 'admin.userprofile.show',
    'uses' => 'Admin\UserProfileController@show',
  ]);
});
