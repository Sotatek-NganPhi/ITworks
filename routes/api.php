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


// Masterdata APIs
Route::get('masterdata', 'MasterdataAPIController@index');
Route::get('masterdata/search-panel', 'MasterdataAPIController@getMasterDataSearchPanel');

Route::group(['middleware' => 'manage.auth'], function () {
    Route::put('bulk_update/{table}', 'MasterdataAPIController@bulkUpdate')->name('api.masterdata.bulk_update');

    // Masterdata APIs
    Route::resource('masterdata', 'MasterdataAPIController',  ['except' => ['index']]);

    // Job related
    Route::resource('jobs', 'JobAPIController');
    Route::resource('expos', 'ExpoAPIController');
    Route::resource('links', 'LinkAPIController');
    Route::resource('pickups', 'PickupAPIController');
    Route::resource('campaigns', 'CampaignAPIController');
    Route::resource('reservations', 'ReservationAPIController');
    Route::resource('special_promotions', 'SpecialPromotionAPIController');
    Route::resource('certificates', 'CertificateAPIController');
    Route::resource('videos', 'VideoAPIController');

    Route::get('counters', 'JobAPIController@applicantJob');
    Route::get('job_qualified', 'JobAPIController@getJobsQualified');
    Route::get('job_getById', 'JobAPIController@getJobsWithIds');
    Route::get('job_urgents', 'JobAPIController@getUrgentJobs');
    Route::put('job_urgents', 'JobAPIController@updateUrgentJobs');

    // Company
    Route::resource('admins', 'AdminAPIController');
    Route::resource('companies', 'CompanyAPIController');
    Route::resource('applicants', 'ApplicantAPIController');
    Route::resource('announcements', 'AnnouncementAPIController');
    Route::get('/get-companies', 'CompanyAPIController@getCompanies');

    // Candidate related
    Route::resource('candidates', 'CandidateAPIController');
    Route::delete('candidates', 'CandidateAPIController@destroyMany');
    Route::resource('social_providers', 'SocialProviderAPIController');
    Route::put('resume/{id}', 'CandidateAPIController@updateResumeInfo');
    Route::resource('mail_setting', 'AutoMailAPIController');
    Route::resource('mail_logs', 'MailLogsAPIController');
    Route::get('candidate/mail_logs/preview/{id}', 'MailLogsAPIController@showmail');
    Route::delete('candidate/{id}/remove-code', 'CandidateAPIController@removeReferralCode');
    Route::get('/candidates/apllicant_list/get_candidate/{id}','ApplicantAPIController@getApplicant');

    // Admin related
    Route::get('get-managers', 'AdminAPIController@getManagers');

    // Utils functions
    Route::post('company/send_email', 'CompanyAPIController@sendMail');
    Route::post('candidates/send-mail', 'CandidateAPIController@sendMail');
    Route::post('candidates/send-mail-to-company', 'CandidateAPIController@sendMailToCompany');
    Route::post('upload-images', 'UploadFileController@uploadFile');

    // TODO: clean us
    Route::resource('analysis', 'AnalysisAPIController');

    Route::post('job/csv/import', 'JobAPIController@importCsv');
    Route::get('analysis/search/month', 'AnalysisAPIController@getMonthSearchAnalysis');
    Route::get('analysis/search/day', 'AnalysisAPIController@getDaySearchAnalysis');
    Route::get('analysis/{year}/{month}/monthly', 'AnalysisAPIController@getMonthlyAnalysis');
    Route::get('analysis/{year}/{month}/dayly', 'AnalysisAPIController@getDaylyAnalysis');
    Route::post('analysis', 'AnalysisAPIController@criteriaAnalysis');
    Route::post('analysis/time', 'AnalysisAPIController@analyzeOverTime');
    Route::get('get-statistical-homepage', 'AdminAPIController@getStatisticalInHomePage');
    Route::get('job/load-rules', 'JobAPIController@loadRules');
    Route::get('{user}/conditions', 'ConditionAPIController@getListCondition');
    Route::delete('{user}/conditions/{id}', 'ConditionAPIController@removeCondition');
    Route::get('counters', 'JobAPIController@applicantJob');
    Route::post('/update', 'AutoMailAPIController@updateMailSetting');

    Route::post('certificate/search', 'CertificateAPIController@searchCertificate');

    Route::resource('messages', 'MessageAPIController');

    Route::get('get-conversations', 'MessageAPIController@getConversations');

    Route::get('get-conversation/{id}', 'MessageAPIController@getConversation');

    Route::post('send-message/{id}', 'MessageAPIController@sendMessage');
});

Route::resource('interviews', 'InterviewAPIController');

Route::get('category-interview', 'InterviewAPIController@getCategories');
