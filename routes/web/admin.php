<?php

Route::post('logout', [
  'as' => 'admin.logout',
  'uses'=> 'Admin\Auth\LoginController@logout',
]);

Route::get('dashboard', [
  'as' => 'admin.home',
  'uses' => 'Admin\HomeController@index',
]);

//Routes for Chart\Role

Route::bind('role', function ($value){
  try {
    return \Chart\Role::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

Route::resource('role', 'Admin\RoleController', ['except' => ['edit','show'], 'as' => 'admin']);

Route::group(['prefix' => 'role'], function () {

  Route::get('/edit/{role}', [
    'as' => 'admin.role.edit',
    'uses' => 'Admin\RoleController@edit',
  ]);

  Route::get('/show/{role}', [
    'as' => 'admin.role.show',
    'uses' => 'Admin\RoleController@show',
  ]);
});

//Routes for Chart\Permission

Route::bind('permission', function ($value){
  try {
    return \Chart\Permission::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

Route::resource('permission', 'Admin\PermissionController', ['except' => ['edit','show'], 'as' => 'admin']);

Route::group(['prefix' => 'permission'], function () {

  Route::get('/edit/{permission}', [
    'as' => 'admin.permission.edit',
    'uses' => 'Admin\PermissionController@edit',
  ]);

  Route::get('/show/{permission}', [
    'as' => 'admin.permission.show',
    'uses' => 'Admin\PermissionController@show',
  ]);
});

//Routes for Chart\User

Route::bind('user', function ($value){
  try {
    return \Chart\User::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

Route::resource('user', 'Admin\UserController', ['except' => ['edit','show'], 'as' => 'admin']);

Route::group(['prefix' => 'user'], function () {

  Route::get('/edit/{user}', [
    'as' => 'admin.user.edit',
    'uses' => 'Admin\UserController@edit',
  ]);

  Route::get('/show/{user}', [
    'as' => 'admin.user.show',
    'uses' => 'Admin\UserController@show',
  ]);
});

//Routes for Chart\UserProfile

Route::bind('userprofile', function ($value){
  try {
    return \Chart\UserProfile::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

Route::group(['prefix' => 'userprofile'], function () {

  Route::get('/edit/{userprofile}', [
    'as' => 'admin.userprofile.edit',
    'uses' => 'Admin\UserProfileController@edit',
  ]);

  Route::put('{userprofile}', [
    'as' => 'admin.userprofile.update',
    'uses' => 'Admin\UserProfileController@update',
  ]);

  Route::get('/show/{userprofile}', [
    'as' => 'admin.userprofile.show',
    'uses' => 'Admin\UserProfileController@show',
  ]);
});
