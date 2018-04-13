<?php

namespace App\Http\Controllers\API;

use Artisan;
use App\Consts;
use App\Http\Services\MasterdataService;
use Illuminate\Support\Facades\DB;
use App\Events\MasterdataChangedEvent;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAdminAPIRequest;
use App\Http\Requests\API\UpdateAdminAPIRequest;
use App\Http\Services\AnalysisService;
use App\Http\Services\JobService;
use App\Repositories\AdminRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Config;
class AutoMailAPIController extends AppBaseController
{
    public function index(Request $request)
    {
         $config = MasterdataService::getOneTable('configs')->where('key', 'mail_auto_settings')->first();
         return $this->sendResponse(json_decode($config->value, true), trans('message.retrieve'));
    }

    public function updateMailSetting(Request $request)
    {
        $quest = json_encode($request->all(),JSON_UNESCAPED_UNICODE);
        Config::where('key', 'mail_auto_settings')->update([
            'value' => $quest
        ]);

        Artisan::call('automail');
        event(new MasterdataChangedEvent());

        return $this->sendResponse(true, trans('message.update'));
    }
}
