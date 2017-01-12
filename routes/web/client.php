<?php

Route::post('logout', [
  'as' => 'client.logout',
  'uses'=> 'Client\Auth\LoginController@logout',
]);

Route::get('dashboard', [
  'as' => 'client.home',
  'uses' => 'Client\HomeController@index',
]);

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
    'as' => 'client.userprofile.edit',
    'uses' => 'Client\UserProfileController@edit',
  ]);

  Route::put('{userprofile}', [
    'as' => 'client.userprofile.update',
    'uses' => 'Client\UserProfileController@update',
  ]);

  Route::get('/show/{userprofile}', [
    'as' => 'client.userprofile.show',
    'uses' => 'Client\UserProfileController@show',
  ]);
});
