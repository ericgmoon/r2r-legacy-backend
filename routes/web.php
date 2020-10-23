<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin-login', 'Auth\AdminLoginController@showLoginForm');
Route::get('/login', function() {
	return redirect()->to('admin-login');
});


Route::post('admin-login', ['as'=>'admin-login','uses'=>'Auth\AdminLoginController@login']);
Route::group(['middleware' => 'auth:admin','prefix' => 'admin','namespace' => 'Admin'], function()
{
	Route::post('logout', 'AdminController@logout')->name('admin.logout');
	Route::get('dashboard','AdminController@index')->name('admin.dashboard');
	Route::get('category-list','AdminController@category_list');
	Route::get('subcategory-list','AdminController@subcategory_list');
	Route::get('content-list/{cat_id}/{subcat_id}','AdminController@content_list');

	Route::get('manage-zone/add/{id?}','ZoneController@zone_form');
	Route::get('manage-zone','ZoneController@zone_list');
	Route::post('manage-zone/add','ZoneController@store');
	Route::get('manage-zone/act-ai/{id}/{status}','ZoneController@update_status');
	Route::get('manage-zone/delete/{id}','ZoneController@del_zone');

	Route::get('manage-zone-questions/add/{zone_id}/{id?}','ZoneController@question_form');
	Route::get('manage-zone-questions/{zone_id}','ZoneController@question_list');
	Route::post('manage-zone-questions/add','ZoneController@question_store');
	Route::get('manage-zone-questions/act-ai/{id}/{status}','ZoneController@update_status');
	Route::get('manage-zone-questions/delete/{id}','ZoneController@del_zone');

	Route::get('manage-users/add/{id?}','UsersController@user_form');
	Route::get('manage-users','UsersController@user_list');
	Route::post('manage-users/add','UsersController@store');
	Route::get('manage-users/act-ai/{id}/{status}','UsersController@update_status');
	Route::get('manage-users/delete/{id}','UsersController@del_user');
	Route::get('manage-users/change-password/{id}','UsersController@change_pwd');
	Route::get('manage-users/assign-tokens/{id}','UsersController@assign_tokens');
	Route::post('manage-users/update-password','UsersController@update_password');
	Route::post('manage-users/assign-tokens','UsersController@update_assign_tokens');
	Route::get('manage-users/add-more-tokens/{id}','UsersController@add_more_tokens');
	Route::post('manage-users/add-more-tokens','UsersController@update_more_tokens');




	Route::get('manage-teams/add/{id?}','TeamController@team_form');
	Route::get('manage-teams','TeamController@team_list');
	Route::post('manage-teams/add','TeamController@store');
	Route::get('manage-teams/act-ai/{id}/{status}','TeamController@update_status');
	Route::get('manage-teams/delete/{id}','TeamController@del_team');

	Route::get('manage-team-users-form/{team_id}','TeamController@team_users_form');
	Route::post('manage-team-users-form','TeamController@post_team_users');
	Route::get('manage-team-zone-form/{team_id}','TeamController@team_zones_form');
	Route::post('manage-team-zone-form','TeamController@post_team_zones');
	Route::get('manage-team-users/delete/{id}/{team_id}','TeamController@delete_team_user');
	Route::get('manage-team-zone/delete/{id}','TeamController@delete_team_zone');

	Route::get('manage-questions/add/{id?}','QuestionsController@question_form');
	Route::get('manage-questions','QuestionsController@question_list');
	Route::post('manage-questions/add','QuestionsController@store');
	Route::get('manage-questions/act-ai/{id}/{status}','QuestionsController@update_status');
	Route::get('manage-questions/delete/{id}','QuestionsController@del_zone');

	Route::get('manage-user-performance','UsersPerformanceController@user_list');
	Route::get('user-questions-performance/{user_id}/{zone_id}','UsersPerformanceController@question_performance_list');
	Route::post('change-question-performance-status','UsersPerformanceController@change_status');


	Route::get('manage-profile','AdminController@myprofile');
	Route::post('manage-personal-details','AdminController@personal');
	Route::post('manage-login-details','AdminController@logindetails');
	Route::post('manage-profile-details','AdminController@profile');

	Route::get('user-feedback','FeedbackController@feedback_list');


});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
