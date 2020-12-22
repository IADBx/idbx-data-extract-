<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('users', ['uses'=>'UserController@index', 'as'=>'users.index']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	#Route::get("/courses",'CourseController@index');
	#Route::get("/course",'CourseController@index');

	Route::apiResource('courses', 'CourseController');

	Route::apiResource('problems', 'ProblemController');

	Route::get('course_dashboard/{id}', ['as' => 'course.dashboard', 'uses' => 'CourseController@dashboard']);
	#Route::get('course_dashboard', ['as' => 'course.dashboard', 'uses' => 'CourseController@surveyInitialTest']);

	Route::get('survey_initial', ['as' => 'survey.initial', 'uses' => 'CourseController@surveyInitial']);
	Route::get('survey_satisfaction', ['as' => 'survey.satisfaction', 'uses' => 'CourseController@surveySatisfaction']);
	Route::get('survey_mqi', ['as' => 'survey.mqi', 'uses' => 'CourseController@surveyMqi']);
	Route::get('survey_individual', ['as' => 'survey.individual', 'uses' => 'CourseController@surveySatisfactionIndividual']);
	Route::get('survey_individual_ganancia', ['as' => 'survey.individual_ganancia', 'uses' => 'CourseController@surveySatisfactionIndividualGanancia']);
	Route::get('survey_individual_promedio', ['as' => 'survey.individual_promedio', 'uses' => 'CourseController@surveySatisfactionIndividualPromedio']);
	Route::get('countries', ['as' => 'course.countries', 'uses' => 'CourseController@courseCountry']);
	Route::get('countries_pea', ['as' => 'course.pea', 'uses' => 'CourseController@courseCountryPea']);

	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

