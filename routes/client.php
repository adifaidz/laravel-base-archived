<?php

$this->router->post('logout', [
  'as' => 'client.logout',
  'uses'=> 'Client\Auth\LoginController@logout',
]);

$this->router->get('dashboard', [
  'as' => 'client.home',
  'uses' => 'Client\HomeController@index',
]);

//Routes for UserProfile

$this->router->bind('userprofile', function ($value){
  try {
    return config('basetrust.userprofile')::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->group(['prefix' => 'userprofile'], function () {

  $this->router->get('/edit/{userprofile}', [
    'as' => 'client.userprofile.edit',
    'uses' => 'Client\UserProfileController@edit',
  ]);

  $this->router->put('{userprofile}', [
    'as' => 'client.userprofile.update',
    'uses' => 'Client\UserProfileController@update',
  ]);

  $this->router->get('/show/{userprofile}', [
    'as' => 'client.userprofile.show',
    'uses' => 'Client\UserProfileController@show',
  ]);
});

//Routes for UserProfile

$this->router->bind('user', function ($value){
  try {
    return config('basetrust.user')::findOrFail($value);
  } catch (Exception $e) {
    return App::abort('404');
  }
}) ;

$this->router->group(['prefix' => 'account'], function () {

  $this->router->get('/edit/{user}', [
    'as' => 'client.account.edit',
    'uses' => 'Client\AccountController@edit',
  ]);

  $this->router->put('{user}', [
    'as' => 'client.account.update',
    'uses' => 'Client\AccountController@update',
  ]);

  $this->router->get('/show/{user}', [
    'as' => 'client.account.show',
    'uses' => 'Client\AccountController@show',
  ]);
});
