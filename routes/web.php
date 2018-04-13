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
// Static pages
Route::get('company', 'HomeController@getCompany')->name('company');
Route::get('sitemap', 'HomeController@showSiteMapPage')->name('sitemap');
Route::get('inquiry', 'HomeController@showInquiryPage')->name('inquiry');
Route::get('rules', 'HomeController@showRulesPage')->name('rules');
Route::get('privacy', 'HomeController@showPrivacyPage')->name('privacy');
Route::get('contact', 'HomeController@showContactPage')->name('contact');
Route::get('spec', 'HomeController@showSpecPage')->name('spec');

Route::post('contact', 'HomeController@sendMailContact');
Route::post('inquiry', 'HomeController@sendMailInquiry');
Route::get('{region}/interview/{id}', 'HomeController@interviewDetail');
Route::get('{region}/interview/cat/{cat}', 'HomeController@interviewPage');

Auth::routes();


Route::get('/{region}/lp', function ($region) {
    $regions = \App\Models\Region::pluck('key')->toArray();
    if (in_array($region, $regions)) {
        return view('app.home.lp');
    } else {
        abort(404);
    }
});

Route::get('/{region}/lp-business', function ($region) {
    $regions = \App\Models\Region::pluck('key')->toArray();
    if (in_array($region, $regions)) {
        return view('app.home.lp_business');
    } else {
        abort(404);
    }
});

// TODO: Re-planning, zoning, naming, ... for routes

Route::get('logout', 'Auth\LoginController@logout')->middleware('auth');

Route::group(['middleware' => ['candidate.register']], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('register/candidate', 'Member\CandidateController@create')->name('candidate.create');
        Route::post('register/candidate', 'Member\CandidateController@store')->name('candidate.store');

        Route::get('candidate/edit', 'Member\CandidateController@edit')->name('candidate.edit');
        Route::post('candidate/update', 'Member\CandidateController@update')->name('candidate.update');
        Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::post('profile/update', 'ProfileController@update')->name('profile.update');
    });

    Route::get('/', function () {
        return redirect()->route('home', 'kanto');
    })->name('index');

    Route::get('/home', function () {
        return redirect()->route('home', 'kanto');
    })->name('home.index');

    Route::get('/homepage', function () {
        return view('index');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('job/{id}/register', 'JobController@apply')->name('job_register');

        Route::group(['prefix' => 'member', 'middleware' => ['auth']], function () {
            Route::get('/', function () {
                return redirect()->route('member_home');
            });

            Route::get('/home', function () {
                return view('app.member.home');
            })->name('member_home');

            Route::get('/clip-list', 'Member\BookmarkController@showBookmarkPage')->name('member_clip_list');

            Route::get('/mail/mail_inbox', 'Member\MailBoxController@showMailInbox')->name('mail_inbox');

            Route::get('/mail/mail_inbox/unread', 'Member\MailBoxController@showMailInboxUnread')->name('mail_inbox_unread');

            Route::get('/mail/mail_inbox/favorite', 'Member\MailBoxController@showMailInboxFavorite')->name('mail_inbox_favorite');

            Route::get('/mail/mail_outbox/favorite', 'Member\MailBoxController@showMailOtboxFavorite')->name('mail_outbox_favorite');

            Route::get('/mail/mail_outbox', 'Member\MailBoxController@showMailOutbox')->name('mail_outbox');

            Route::get('/mail/mail_box/{applicantId}', 'Member\MailBoxController@showMailBox')->name('mail_box');

            Route::post('/mail/mail_box/reply', 'Member\MailBoxController@replyMessage')->name('reply_message');

            Route::get('/apply_manage', 'ApplicationController@showAppliedJobs')->name('member_application_list');

            Route::get('/resume_register', 'Member\CandidateController@candidateResume')->name('resume_register');

            Route::delete('bookmark/{job}', 'Member\BookmarkController@deleteBookmark')->name('delete_bookmark');

            Route::get('register-conditions', 'Member\ConditionController@showListConditionPage')->name('member_show_register_condition');

            Route::get('/leave/confirm', function() {
                return view('app.member.leave');
            })->name('member_leave_confirm');


            Route::post('/leave/ok', 'Member\CandidateController@leave')->name('member_leave_ok');

            Route::post('resume_register', 'Member\CandidateController@updateResumeInfo');

            Route::post('conversation/favorite/{id}', 'Member\MailBoxController@favoriteConversation');

        });
    });
    Route::post('job/{id}/register', 'ApplicationController@store')->name('apply_job');

    Route::post('/job-reference', 'JobController@getJobReference');

    Route::get('/{region}/home', 'HomeController@layoutHomePage')->name('home');

    Route::get('{region}/job', 'JobController@search')->name('search');

    Route::get('{region}/videos', 'API\VideoAPIController@showVideoList')->name('video_list');

    Route::get('{region}/video/{id}', 'API\VideoAPIController@showVideoDetail')->name('video');

    Route::get('job/{id}', 'JobController@show')->name('job_detail');

    Route::get('job/{id}/send-mobile', 'JobController@showJobSendMobile')->name('show_job_send_mobile');

    Route::post('job/{job}/send-mobile', 'JobController@sendJobToMailMobile')->name('send_job_send_mobile');

    Route::get('job/{job}/clips', 'JobController@showJobClips')->name('show_job_clips');

    Route::post('job/{job}/clips', 'JobController@addJobClips')->name('add_job_clips');

    Route::get('/about/special/{id}', 'SpecialPromotionController@show');

    Route::get('/expo/{id}/regist', 'ExpoController@getLayout')->name('regist_expo');

    Route::post('/api/expos/{id}/register', 'ExpoController@veryRegister')->name('register_expo');
    Route::post('/api/expos/{id}/register/ok', 'ExpoController@register');

    Route::get('/campaign/{id}', 'HomeController@showDetailCampain');

    Route::get('/{region}', function ($region) {
        $regions = \App\Models\Region::pluck('key')->toArray();
        if (in_array($region, $regions)) {
            return redirect()->route('home', $region);
        } else {
            abort(404);
        }
    });

    Route::get('{region}/{prefecture}/wards/{ward?}', 'HomeController@searchJobByWard')->name('search_job:ward');

    Route::get('{region}/{prefecture}/lines/{station?}', 'HomeController@searchJobByLine')->name('search_job:line');

    Route::get('{region}/{prefecture}/lines/{line?}/stations/{station?}', 'HomeController@searchJobByStation')->name('search_job:station');
});

Route::get('/candidate/current', 'Member\CandidateController@getCurrentCandidate');

Route::get('register/verify/{confirmationCode}', 'Auth\RegisterController@confirm')->name('confirmation');

Route::get('register/{user}/resend', 'Auth\RegisterController@resendVerification')->name('resend_verification');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('auth.provider');

Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

