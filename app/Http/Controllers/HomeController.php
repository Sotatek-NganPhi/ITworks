<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\SendMailContactRequest;
use App\Http\Services\JobService;
use App\Http\Services\UrgentJobService;
use App\Mail\Contact as ContactMail;
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
    protected $urgentJobService;

    public function __construct(
        JobService $jobService, UrgentJobService $urgentJobService
        )
    {
        $this->jobService = $jobService;
        $this->urgentJobService = $urgentJobService;
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
                'today' => Carbon::now(Consts::TIME_ZONE_VIETNAM),
                'regions' => Region::getAll(),
                'keyRegion' => $keyRegion,
                'listPrefecture' => Region::getPrefectures($regionId),
                'urgentJobs' => $this->urgentJobService->getActiveUrgentJobs($prefectureIds),
                'attentionJobs' => $this->jobService->getAttentionJobs($prefectureIds, 6),
            ]
        );
    }

    public function showContactPage()
    {
        return $this->_showStaticPage('contact');
    }

    public function showPrivacyPage()
    {
        return $this->_showStaticPage('privacy');
    }

    public function showRulesPage()
    {
        return $this->_showStaticPage('rules');
    }

    public function _showStaticPage($pageName)
    {
        return view('app.' . $pageName);
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
}
