<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\SendMailContactRequest;
use App\Http\Services\AnnouncementService;
use App\Http\Services\JobService;
use App\Http\Services\CampaignService;
use App\Http\Services\UrgentJobService;
use App\Http\Services\SpecialJobService;
use App\Http\Services\InterviewService;
use App\Mail\Contact as ContactMail;
use App\Mail\Inquiry as InquiryMail;
use App\Models\Campaign;
use App\Models\Config;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Exception;

class HomeController extends AppBaseController
{
    protected $jobService;
    protected $announcementService;
    protected $urgentJobService;
    protected $specialService;
    protected $campaignService;
    protected $interviewService;

    public function __construct(
        JobService $jobService, UrgentJobService $urgentJobService, SpecialJobService $specialService, AnnouncementService $announcementService,
        CampaignService $campaignService, InterviewService $interviewService)
    {
        $this->jobService = $jobService;
        $this->announcementService = $announcementService;
        $this->urgentJobService = $urgentJobService;
        $this->specialService = $specialService;
        $this->campaignService = $campaignService;
        $this->interviewService = $interviewService;
    }

    public function layoutHomePage($keyRegion)
    {
        $region = Region::getRegionByKey($keyRegion);
        if (is_null($region)) {
            return abort(404);
        }

        $regionId = $region->id;
        $prefectureIds = Region::getPrefectureIds($regionId);

        return view(
            'app.home.index',
            [
                'today' => Carbon::now(Consts::TIME_ZONE_JAPAN),
                'regions' => Region::getAll(),
                'keyRegion' => $keyRegion,
                'listPrefecture' => Region::getPrefectures($regionId),
                'announcements' => $this->announcementService->getActiveAnnouncements($regionId),
                'specialPromotions' => $this->specialService->getActiveSpecialPromotions($regionId),
                'urgentJobs' => $this->urgentJobService->getActiveUrgentJobs($prefectureIds),
                'attentionJobs' => $this->jobService->getAttentionJobs($prefectureIds, 6),
                'campaign' => $this->campaignService->getActiveCampain(),
                'interviewHome' => $this->interviewService->getListInterview(Consts::INTERVIEW_LIMIT, $keyRegion),
//                'totalJobNew' => $this->jobService->getTotalJobNewInDay()
            ]
        );
    }

    public function showDetailCampain($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('app.campain', [
            'campaign' => $campaign,
        ]);
    }

    public function showSiteMapPage()
    {
        $region = Region::findOneById(2);
        $prefectureIds = Region::getPrefectureIds($region->id);
        return view('app.site_map', [
            'jobCounts' => $this->jobService->getJobCounts($region->key, $prefectureIds),
            'keyRegion' => $region->key,
        ]);
    }

    public function getCompany()
    {
        return $this->_showStaticPage('company');
    }

    public function showContactPage()
    {
        return $this->_showStaticPage('contact');
    }

    public function showInquiryPage()
    {
        return $this->_showStaticPage('inquiry');
    }

    public function showPrivacyPage()
    {
        return $this->_showStaticPage('privacy');
    }

    public function showRulesPage()
    {
        return $this->_showStaticPage('rules');
    }

    public function showSpecPage()
    {
        return $this->_showStaticPage('spec');
    }

    public function _showStaticPage($pageName)
    {
        return view('app.' . $pageName);
    }

    public function sendMailInquiry(SendMailInquiryRequest $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['confirm'])) {
            return response()->view('app.inquiry', [
                'errors' => [],
                'inputs' => $inputs,
                'submitted' => true
            ]);
        }

        $configs = Config::getConfigByKey();

        Mail::to(['email' => $configs['company_email']])
            ->queue(new InquiryMail($inputs));

        Inquiry::create($inputs);

        return response()->view('app.inquiry', [
            'errors' => [],
            'inputs' => $inputs,
            'success' => true
        ]);
    }

    public function sendMailContact(SendMailContactRequest $request)
    {
        $inputs = $request->all();

        if (!isset($inputs['confirm'])) {
            return response()->view('app.contact', [
                'errors' => [],
                'inputs' => $inputs,
                'submitted' => true
            ]);
        }

        $configs = Config::getConfigByKey();

        Mail::to(['email' => $configs['company_email']])
            ->queue(new ContactMail($inputs));

        Contact::create($inputs);

        return response()->view('app.contact', [
            'errors' => [],
            'inputs' => $inputs,
            'success' => true
        ]);
    }

    public function interviewDetail($keyRegion, $id)
    {
        $interviews = $this->interviewService->getInterviewById($id);
        $regions = Region::all();
        return view(
            'app.interview_detail',
            [
                'interviews' => $interviews,
                'regions' => $regions,
                'keyRegion' => $keyRegion
            ]
        );
    }
    public function interviewPage($keyRegion, $categoryInterviewId)
    {
        $regions = Region::all();
        $interviews = $this->interviewService->getListByCategory($categoryInterviewId, Consts::INTERVIEW_PAGE_LIMIT, $keyRegion);
        $isAll = false;

        if($categoryInterviewId === Consts::ALL_CATEGORIES)
        {
            $interviews = $this->interviewService->getListInterview(Consts::INTERVIEW_PAGE_LIMIT, $keyRegion);
            $isAll = true;
        }

        return view(
            'app.interview_page',
            [
                'interviewPage' => $interviews,
                'isAll' => $isAll,
                'regions' => $regions,
                'keyRegion' => $keyRegion
            ]
        );
    }
}
