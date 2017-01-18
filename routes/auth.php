<?php
$this->router->get('admin/login', [
  'as' => 'admin.login',
  'uses' => 'Admin\Auth\LoginController@showLoginForm',
]);

$this->router->post('admin/login', [
  'uses'=> 'Admin\Auth\LoginController@login',
]);

$this->router->get('/', [
  'as' => 'client.login',
  'uses' => 'Client\Auth\LoginController@showLoginForm',
]);

$this->router->post('login', [
  'uses'=> 'Client\Auth\LoginController@login',
]);

$this->router->get('password/reset', [
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
]);
$this->router->post('password/reset', [
  'uses' => 'Auth\ResetPasswordController@reset',
]);

$this->router->get('password/reset/{token}', [
  'uses' => 'Auth\ResetPasswordController@showResetForm',
]);

$this->router->post('password/email', [
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
