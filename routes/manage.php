<?php

Route::get('/login','Manage\LoginController@showLoginForm');

Route::post('/login','Manage\LoginController@login');

Route::group(['middleware' => 'manage.auth'], function () {
    Route::get('/', 'Manage\ManagerController@index');

    Route::get('/companies/csv', 'API\CompanyAPIController@downloadCsv');

    Route::get('/applicants/csv', 'API\ApplicantAPIController@downloadCsv');

    Route::get('/applicants/csv/{id}', 'API\ApplicantAPIController@downloadOneApplicant');

    Route::get('/mail_log/csv', 'API\MailLogsAPIController@downloadCsv');

    Route::get('/announcement/csv', 'API\AnnouncementAPIController@downloadCsv');

    Route::get('/jobs/csv', 'API\JobAPIController@downloadCsv');

    Route::get('/jobs/csv/sample', 'JobController@downloadSampleCsv');

    Route::get('/special/csv', 'API\SpecialPromotionAPIController@downloadCSV');

    Route::get('/pickup/csv', 'API\PickupAPIController@downloadCsv');

    Route::get('/analysis/csv', 'API\AnalysisAPIController@downloadCsv');

    Route::post('/logout','Manage\LoginController@logout');

    Route::prefix('csv')->group(function () {

        Route::get('category_level2s', 'JobController@downloadCsvCategoryLevel2s');

        Route::get('prefectures', 'JobController@downloadCsvPrefectures');

        Route::get('wards', 'JobController@downloadCsvWards');

        Route::get('merits', 'JobController@downloadMerits');

        Route::get('employment_modes', 'JobController@downloadCsvEmploymentModes');

        Route::get('working_shifts', 'JobController@downloadCsvWorkingShifts');

        Route::get('working_days', 'JobController@downloadCsvWorkingDays');

        Route::get('working_hours', 'JobController@downloadCsvWorkingHours');

        Route::get('working_periods', 'JobController@downloadCsvWorkingPeriods');

        Route::get('salaries', 'JobController@downloadCsvSalaries');

        Route::get('current_situations', 'JobController@downloadCsvCurrentSituations');

        Route::get('stations', 'JobController@downloadCsvRoutesStations');
    });
});