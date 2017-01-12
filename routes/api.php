<?php
//Routes for Chart\Role

Route::get('/role', [
  'as' => 'api.role',
  'uses' => 'Api\RoleController@role',
]);

//Routes for Chart\Permission

Route::get('/permission', [
  'as' => 'api.permission',
  'uses' => 'Api\PermissionController@permission',
]);

//Routes for Chart\User

Route::get('/user', [
  'as' => 'api.user',
  'uses' => 'Api\UserController@user',
]);

//Routes for Chart\UserProfile

Route::get('/userprofile', [
  'as' => 'api.userprofile',
  'uses' => 'Api\UserProfileController@userprofile',
]);
