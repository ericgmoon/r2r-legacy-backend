<?php

use Illuminate\Http\Request;

Route::group(['namespace'=>'API'], function(){

	Route::any('login', 'UserController@login');
	Route::any('register', 'UserController@register');
	Route::any('forgot-password','UserController@forgotPassword');
	Route::any('verify-otp','UserController@verifyOtp');
	Route::any('change-password','UserController@changePassword');

});

Route::group(['middleware'=> 'auth:api','namespace'=>'API'], function(){

	// Users
	Route::get('user', 'UserController@user_details');
	Route::get('get-user-profile', 'UserController@get_user_profile');
	Route::post('update-user-profile', 'UserController@update_user_profile');
	Route::post('update-password', 'UserController@updatePassword');
	Route::get('available-zones', 'UserController@available_zones');
	Route::post('zone-riddles', 'UserController@zone_riddles');
	Route::post('get-riddle', 'UserController@get_riddles');
	Route::post('get-hint', 'UserController@get_hint');
	Route::post('submit-riddle', 'UserController@submit_riddle');
	Route::post('submit-abandoned', 'UserController@submit_abandoned');
	Route::post('submit-feedback', 'UserController@submit_feedback');
	Route::post('submit-taunt', 'UserController@submit_taunt');
	//Route::post('update_profile', 'UserController@updateProfile');


	Route::get('get-leaderboard', 'UserController@get_leaderboard');
	Route::get('get-teammate', 'UserController@get_teammate');
	Route::get('get-team', 'UserController@get_team');
	Route::post('get-team-members', 'UserController@get_team_members');
	
	// auth
	Route::get('logout', 'UserController@logout');

	
});

