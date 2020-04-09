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
        $user =  $request->user();
        $user->attendance;
        return $user;
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
    Route::get('status',"Admin\StatusController@status");
    Route::post('taskupdata',"Admin\TaskController@taskupdata");
    Route::post('posupdata',"Admin\TaskController@posupdata");
    Route::get('attendances/update/{id}',"Admin\AdminController@attendancesUpdate");
    Route::post('checkin',"Admin\AdminController@checkIn");

    Route::resource('clients', 'Admin\ClientController')->except([
        'show', 'edit'
    ]);
    Route::get('clients/all', 'Admin\ClientController@all');
    Route::get('clientsearch/{query}', 'Admin\ClientController@query');
    Route::get('issuesearch/{query}', 'Admin\IssueController@query');
    Route::get('projectsearch/{query}', 'Admin\ProjectController@query');
    Route::get('issueforslient/{id}', 'Admin\ClientController@issue');
    Route::get('taskforissue/{id}', 'Admin\TaskController@task');
    Route::get('issueforprojectsearch/{id}', 'Admin\ProjectController@issue');

    Route::resource('districts', 'Admin\DistrictController')->except(['show', 'edit']);
    Route::get('districts/all', 'Admin\DistrictController@all');
    Route::resource('upazilas', 'Admin\UpazilaController')->except(['show', 'edit']);
    
    Route::resource('projects', 'Admin\ProjectController')->except([
        'show', 'edit'
    ]);
    Route::get('projects/all', 'Admin\ProjectController@all');

    Route::resource('issues', 'Admin\IssueController')->except([
       'edit'
    ]);

    Route::post('issues/statusupdate', 'Admin\IssueController@statusupdate');


    Route::resource('issuecomment', 'Admin\IssuecommentController');
    Route::resource('comment', 'Admin\CommentController');

    Route::resource('tasks', 'Admin\TaskController')->except([
       'edit'
    ]);
    
    Route::resource('departments', 'Admin\DepartmentController')->except([
        'show', 'edit'
    ]);


    Route::get('departments/all', 'Admin\DepartmentController@all');

    Route::resource('designations', 'Admin\DesignationController')->except([
        'show', 'edit'
    ]);
    Route::resource('notices', 'Admin\NoticeController')->except([
        'show', 'edit'
    ]);
    Route::resource('weekends', 'Admin\WeekendController')->except([
        'show', 'edit'
    ]);
    Route::resource('holidays', 'Admin\HolidayController')->except([
        'show', 'edit'
    ]);
    Route::resource('issue_types', 'Admin\IssueTypeController')->except([
        'show', 'edit'
    ]);
    Route::get('issue_types/all', 'Admin\IssueTypeController@all');

    Route::resource('statuses', 'Admin\StatusController')->except([
        'show', 'edit'
    ]);
    Route::resource('attendances', 'Admin\AttendanceController')->except([
        'show', 'edit'
    ]);

    Route::get('statuses/all', 'Admin\StatusController@all');
    Route::get('users', 'Settings\ProfileController@users');
}); // this should be the absolute last line of this file
