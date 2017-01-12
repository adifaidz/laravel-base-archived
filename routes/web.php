<?php
Route::get('admin/login', [
  'as' => 'admin.login',
  'uses' => 'Admin\Auth\LoginController@showLoginForm',
]);

Route::post('admin/login', [
  'uses'=> 'Admin\Auth\LoginController@login',
]);

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
  File::requireOnce( __DIR__.'/web/admin.php');
});

Route::get('/', [
  'as' => 'client.login',
  'uses' => 'Client\Auth\LoginController@showLoginForm',
]);

Route::post('login', [
  'uses'=> 'Client\Auth\LoginController@login',
]);

Route::group(['middleware' => 'client'], function () {
  File::requireOnce( __DIR__.'/web/client.php');
});

Route::get('password/reset', [
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
]);
Route::post('password/reset', [
  'uses' => 'Auth\ResetPasswordController@reset',
]);

Route::get('password/reset/{token}', [
  'uses' => 'Auth\ResetPasswordController@showResetForm',
]);

Route::post('password/email', [
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
