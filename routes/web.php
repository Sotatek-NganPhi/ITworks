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
Route::get('rules', 'HomeController@showRulesPage')->name('rules');
Route::get('privacy', 'HomeController@showPrivacyPage')->name('privacy');
Route::get('contact', 'HomeController@showContactPage')->name('contact');
Route::post('contact', 'HomeController@sendMailContact');

Auth::routes();


Route::get('/{region}/lp', function ($region) {
    $regions = \App\Models\Region::pluck('key')->toArray();
    if (in_array($region, $regions)) {
        return view('app.home.lp');
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
        return redirect()->route('home', 'hanoi');
    })->name('index');

    Route::get('/home', function () {
        return redirect()->route('home', 'hanoi');
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


    Route::get('job/{id}', 'JobController@show')->name('job_detail');


    Route::get('job/{job}/clips', 'JobController@showJobClips')->name('show_job_clips');

    Route::post('job/{job}/clips', 'JobController@addJobClips')->name('add_job_clips');

    Route::get('/{region}', function ($region) {
        $regions = \App\Models\Region::pluck('key')->toArray();
        if (in_array($region, $regions)) {
            return redirect()->route('home', $region);
        } else {
            abort(404);
        }
    });

});

Route::get('/candidate/current', 'Member\CandidateController@getCurrentCandidate');

Route::get('register/verify/{confirmationCode}', 'Auth\RegisterController@confirm')->name('confirmation');

Route::get('register/{user}/resend', 'Auth\RegisterController@resendVerification')->name('resend_verification');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('auth.provider');

Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

