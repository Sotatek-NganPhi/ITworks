<?php

Route::get('/login','Manage\LoginController@showLoginForm');

Route::post('/login','Manage\LoginController@login');

Route::group(['middleware' => 'manage.auth'], function () {
    Route::get('/', 'Manage\ManagerController@index');

    Route::get('/companies/csv', 'API\CompanyAPIController@downloadCsv');

    Route::get('/applicants/csv', 'API\ApplicantAPIController@downloadCsv');

    Route::get('/applicants/csv/{id}', 'API\ApplicantAPIController@downloadOneApplicant');

    Route::get('/announcement/csv', 'API\AnnouncementAPIController@downloadCsv');

    Route::get('/jobs/csv', 'API\JobAPIController@downloadCsv');

    Route::get('/analysis/csv', 'API\AnalysisAPIController@downloadCsv');

    Route::post('/logout','Manage\LoginController@logout');

    Route::prefix('csv')->group(function () {

        Route::get('prefectures', 'JobController@downloadCsvPrefectures');

        Route::get('working_days', 'JobController@downloadCsvWorkingDays');

        Route::get('working_hours', 'JobController@downloadCsvWorkingHours');

        Route::get('salaries', 'JobController@downloadCsvSalaries');
    });
});