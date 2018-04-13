<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\SendMailContactRequest;
use App\Http\Requests\SendMailInquiryRequest;
use App\Http\Services\AnnouncementService;
use App\Http\Services\ExpoService;
use App\Http\Services\JobService;
use App\Http\Services\LinkService;
use App\Http\Services\PickupService;
use App\Http\Services\CampaignService;
use App\Http\Services\UrgentJobService;
use App\Http\Services\SpecialJobService;
use App\Http\Services\VideoService;
use App\Http\Services\InterviewService;
use App\Mail\Contact as ContactMail;
use App\Mail\Inquiry as InquiryMail;
use App\Models\Campaign;
use App\Models\Config;
use App\Models\Prefecture;
use App\Models\RailwayLine;
use App\Models\Region;
use App\Models\Inquiry;
use App\Models\Contact;
use App\Models\Station;
use App\Models\Video;
use App\Models\Ward;
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
    protected $expoService;
    protected $pickupService;
    protected $linkService;
    protected $announcementService;
    protected $urgentJobService;
    protected $specialService;
    protected $campaignService;
    protected $videoService;
    protected $interviewService;

    public function __construct(
        JobService $jobService, ExpoService $expoService, PickupService $pickupService,
        LinkService $linkService, AnnouncementService $announcementService,
        UrgentJobService $urgentJobService, SpecialJobService $specialService,
        CampaignService $campaignService, VideoService $videoService,
        InterviewService $interviewService)
    {
        $this->jobService = $jobService;
        $this->expoService = $expoService;
        $this->pickupService = $pickupService;
        $this->linkService = $linkService;
        $this->announcementService = $announcementService;
        $this->urgentJobService = $urgentJobService;
        $this->specialService = $specialService;
        $this->campaignService = $campaignService;
        $this->videoService = $videoService;
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
                'expos' => $this->expoService->getActiveExpos($regionId),
                'campaign' => $this->campaignService->getActiveCampain(),
//                'jobCounts' => $this->jobService->getJobCounts($keyRegion, $prefectureIds),
                'pickups' => $this->pickupService->getActivePickups($keyRegion),
                'links' => $this->linkService->getActiveLinks($regionId),
                'videos' => $this->videoService->getActiveVideos($regionId),
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

    public function searchJobByWard(Request $request, $regionSelected, $prefectureSelected, $keyWardSelected = null)
    {
        try {
            if(is_null($keyWardSelected)) {
                $params = $request->all();
                $keyWardSelected = [];
                foreach ($params as $key => $param) {
                    if (strpos($key, 'ward') !== false) {
                        $keyWardSelected[] = $param;
                    }
                }
            }
            $prefecture = Prefecture::findOne('name_en', $prefectureSelected);
            $region = Region::getRegionByKey($regionSelected);
            $jobs = $this->jobService->searchJobByWard($request, $prefecture, $keyWardSelected);
            $wards = $this->getWardWithTotalJobInPrefecture($prefecture);
            return view('app.search_ward',
                [
                    'regions' => Region::getAll(),
                    'jobs' => $jobs,
                    'region' => $region,
                    'wards' => $wards,
                    'wardSelected' => $keyWardSelected,
                    'prefecture' => $prefecture,
                    'free_word' => $request->input('free_word'),
                    'category' => $request->input('category'),
                    'employment_mode' => $request->input('employment_mode'),
                    'merits' => $request->input('merits'),
                ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function searchJobByLine(Request $request, $regionSelected, $prefectureSelected, $lineSelected = null)
    {
        try {
            $params = $request->all();
            if(is_null($lineSelected)) {
                $lineSelected = [];
                foreach ($params as $key => $param) {
                    if (strpos($key, 'line') !== false) {
                        $lineSelected[] = $param;
                    }
                }
            }
            $stationSelected = [];
            foreach ($params as $key => $param) {
                if (strpos($key, 'station') !== false) {
                    $stationSelected[] = $param;
                }
            }
            $prefecture = Prefecture::findOne('name_en', $prefectureSelected);
            $region = Region::getRegionByKey($regionSelected);
            $jobs = $this->jobService->searchJobByLine($request, $prefecture, $lineSelected, $stationSelected);
            $lines = $this->getLineWithTotalJobInPrefecture($prefecture);
            $stations = $this->getStationWithTotalJobInPrefecture($prefecture);
            return view('app.search_station',
                [
                    'regions' => Region::getAll(),
                    'jobs' => $jobs,
                    'region' => $region,
                    'prefecture' => $prefecture,
                    'lines' => $lines,
                    'stations' => $stations,
                    'lineSelected' => $lineSelected,
                    'free_word' => $request->input('free_word'),
                    'category' => $request->input('category'),
                    'employment_mode' => $request->input('employment_mode'),
                    'merits' => $request->input('merits'),

                ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function searchJobByStation(Request $request, $regionSelected,
                                       $prefectureSelected, $lineSelected, $stationSelected = null)
    {
        try {
            if(is_null($stationSelected)) {
                $params = $request->all();
                $stationSelected = [];
                foreach ($params as $key => $param) {
                    if (strpos($key, 'station') !== false) {
                        $stationSelected[] = $param;
                    }
                }
            }
            $prefecture = Prefecture::findOne('name_en', $prefectureSelected);
            $region = Region::getRegionByKey($regionSelected);
            $jobs = $this->jobService->searchJobByStation($request, $prefecture, $lineSelected, $stationSelected);
            $lines = $this->getLineWithTotalJobInPrefecture($prefecture);
            $stations = $this->getStationWithTotalJobInPrefecture($prefecture);
            return view('app.search_station',
                [
                    'regions' => Region::getAll(),
                    'jobs' => $jobs,
                    'region' => $region,
                    'prefecture' => $prefecture,
                    'lines' => $lines,
                    'stations' => $stations,
                    'lineSelected' => $lineSelected,
                    'free_word' => $request->input('free_word'),
                    'category' => $request->input('category'),
                    'employment_mode' => $request->input('employment_mode'),
                    'merits' => $request->input('merits'),

                ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    protected function getWardWithTotalJobInPrefecture($prefecture)
    {
        $CACHE_KEY = 'Search:getWardWithTotalJobInPrefecture?prefectureId='.$prefecture->id;
        $wards = Cache::tags('search')->get($CACHE_KEY);
        if(!is_null($wards)) {
           return $wards;
        }
        $wards = Ward::select('wards.id', 'wards.name', 'wards.name_en', 'wards.prefecture_id',
            DB::raw('COUNT(job_ward.job_id) as total_job'))
            ->where('prefecture_id', $prefecture->id)
            ->leftJoin('job_ward', 'job_ward.ward_id', 'wards.id')
            ->groupBy('wards.id')
            ->get();
        Cache::tags('search')->forever($CACHE_KEY, $wards);
        return $wards;
    }

    protected function getLineWithTotalJobInPrefecture($prefecture)
    {
        $CACHE_KEY = 'Search:getLineWithTotalJobInPrefecture?prefectureId='.$prefecture->id;

        $lines = Cache::tags('search')->get($CACHE_KEY);
        if(!is_null($lines)) {
            return $lines;
        }

        $lines = RailwayLine::select('railway_lines.id', 'railway_lines.name', 'railway_lines.name_en', 'stations.prefecture_id',
            DB::raw('COUNT(job_routes.job_id) as total_job'))
            ->join('line_stations', 'line_stations.line_id', 'railway_lines.id')
            ->join('stations', 'stations.id', 'line_stations.station_id')
            ->leftJoin('job_routes', 'job_routes.line_station_id', 'line_stations.id')
            ->where('stations.prefecture_id', $prefecture->id)
            ->groupBy('railway_lines.id')
            ->orderBy('railway_lines.id')
            ->get();
        Cache::tags('search')->forever($CACHE_KEY, $lines);
        return $lines;
    }

    protected function getStationWithTotalJobInPrefecture($prefecture)
    {
        $CACHE_KEY = 'Search:getStationWithTotalJobInPrefecture?prefectureId='.$prefecture->id;

        $stations = Cache::tags('search')->get($CACHE_KEY);
        if(!is_null($stations)) {
            return $stations;
        }

        $stations = Station::select('stations.id', 'stations.name', 'stations.name_en',
            'line_stations.line_id', 'stations.prefecture_id',
            DB::raw('COUNT(job_routes.job_id) as total_job'))
            ->join('line_stations', 'line_stations.station_id', 'stations.id')
            ->leftJoin('job_routes', 'job_routes.line_station_id', 'line_stations.id')
            ->where('stations.prefecture_id', $prefecture->id)
            ->groupBy('stations.id', 'line_id')
            ->orderBy('stations.id')
            ->get();

        Cache::tags('search')->forever($CACHE_KEY, $stations);
        return $stations;
    }
}
