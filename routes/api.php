<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});


Route::group([
    'middleware' => ['auth:api'],
], function () { // custom admin routes
    Route::get('attendances',"Admin\AdminController@attendances");
    Route::get('attendances/update/{id}',"Admin\AdminController@attendancesUpdate");
    Route::post('checkin',"Admin\AdminController@checkIn");

    Route::resource('clients', 'Admin\ClientController')->except([
        'show', 'edit'
    ]);
    Route::resource('projects', 'Admin\ProjectController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('issues', 'Admin\IssueController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('tasks', 'Admin\TaskController')->except([
        'create', 'show', 'edit'
    ]);
    
    Route::resource('departments', 'Admin\DepartmentController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('designations', 'Admin\DesignationController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('notices', 'Admin\NoticeController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('weekends', 'Admin\WeekendController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('holidays', 'Admin\HolidayController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('issue_types', 'Admin\IssueTypeController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('statuses', 'Admin\StatusController')->except([
        'create', 'show', 'edit'
    ]);
    Route::resource('attendances', 'Admin\AttendanceController')->except([
        'create', 'show', 'edit'
    ]);
}); // this should be the absolute last line of this file
