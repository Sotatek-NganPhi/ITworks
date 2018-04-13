<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Services\MasterdataService;
use App\Models\Prefecture;
use App\Models\Region;
use App\Events\MasterdataChangedEvent;
use App\Repositories\ReferralAgencyRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Request;
use App\Http\Requests\API\CreateMasterdataAPIRequest;
use App\Http\Requests\API\UpdateMasterdataAPIRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;
use Validator;
use App\Consts;

use App\Repositories\CategoryLevel1Repository;
use App\Repositories\CategoryLevel2Repository;
use App\Repositories\CategoryLevel3Repository;
use App\Repositories\CompanySizeRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\CurrentSituationRepository;
use App\Repositories\DriverLicenseRepository;
use App\Repositories\EducationRepository;
use App\Repositories\EmploymentModeRepository;
use App\Repositories\FieldSettingRepository;
use App\Repositories\IndustryRepository;
use App\Repositories\JumpingConditionRepository;
use App\Repositories\JumpingDateRepository;
use App\Repositories\LanguageConversationLevelRepository;
use App\Repositories\LanguageExperienceRepository;
use App\Repositories\LineStationRepository;
use App\Repositories\MeritGroupRepository;
use App\Repositories\MeritRepository;
use App\Repositories\PositionRepository;
use App\Repositories\PrefectureRepository;
use App\Repositories\RailwayLineRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SalaryRepository;
use App\Repositories\StationRepository;
use App\Repositories\WardRepository;
use App\Repositories\WorkingDayRepository;
use App\Repositories\WorkingHourRepository;
use App\Repositories\WorkingPeriodRepository;
use App\Repositories\WorkingShiftRepository;
use App\Repositories\CertificateRepository;
use App\Repositories\CertificateGroupRepository;
use InfyOm\Generator\Utils\ResponseUtil;
/**
 * Class AdminController
 * @package App\Http\Controllers\API
 */
class MasterdataAPIController extends AppBaseController
{
    const TABLE_PARAM_NAME = '_table';

    private $repos;

    public function __construct(
        CategoryLevel1Repository                $catLevel1Repo,
        CategoryLevel2Repository                $catLevel2Repo,
        CategoryLevel3Repository                $catLevel3Repo,
        CompanySizeRepository                   $companySizeRepos,
        ConfigRepository                        $configRepo,
        CurrentSituationRepository              $currentSituationRepo,
        DriverLicenseRepository                 $driverLicenseRepo,
        EducationRepository                     $educationRepo,
        EmploymentModeRepository                $employmentModeRepo,
        FieldSettingRepository                  $fieldSettingRepo,
        IndustryRepository                      $industryRepo,
        JumpingConditionRepository              $jumpingConditionRepo,
        JumpingDateRepository                   $jumpingDateRepo,
        LanguageConversationLevelRepository     $languageConversationLevelRepo,
        LanguageExperienceRepository            $languageExperienceRepo,
        LineStationRepository                   $lineStationRepo,
        MeritGroupRepository                    $meritGroupRepo,
        MeritRepository                         $meritRepo,
        PositionRepository                      $positionRepo,
        PrefectureRepository                    $prefectureRepo,
        RailwayLineRepository                   $railwayLineRepo,
        RegionRepository                        $regionRepo,
        SalaryRepository                        $salaryRepo,
        StationRepository                       $stationRepo,
        WardRepository                          $wardRepo,
        WorkingDayRepository                    $workingDayRepo,
        WorkingHourRepository                   $workingHourRepo,
        WorkingPeriodRepository                 $workingPeriodRepo,
        WorkingShiftRepository                  $workingShiftRepo,
        CertificateRepository                   $certificateRepo,
        CertificateGroupRepository              $certificateGroupRepo,
        ReferralAgencyRepository                $referralAgencyRepo)
    {
        $this->repos = [
            'category_level1s' => $catLevel1Repo,
            'category_level2s' => $catLevel2Repo,
            'category_level3s' => $catLevel3Repo,
            'company_sizes' => $companySizeRepos,
            'configs' => $configRepo,
            'current_situations' => $currentSituationRepo,
            'driver_licenses' => $driverLicenseRepo,
            'educations' => $educationRepo,
            'employment_modes' => $employmentModeRepo,
            'field_settings' => $fieldSettingRepo,
            'industries' => $industryRepo,
            'jumping_conditions' => $jumpingConditionRepo,
            'jumping_dates' => $jumpingDateRepo,
            'language_conversation_levels' => $languageConversationLevelRepo,
            'language_experiences' => $languageExperienceRepo,
            'line_stations' => $lineStationRepo,
            'merit_groups' => $meritGroupRepo,
            'merits' => $meritRepo,
            'positions' => $positionRepo,
            'prefectures' => $prefectureRepo,
            'railway_lines' => $railwayLineRepo,
            'regions' => $regionRepo,
            'salaries' => $salaryRepo,
            'stations' => $stationRepo,
            'wards' => $wardRepo,
            'working_days' => $workingDayRepo,
            'working_hours' => $workingHourRepo,
            'working_periods' => $workingPeriodRepo,
            'working_shifts' => $workingShiftRepo,
            'certificates' => $certificateRepo,
            'certificate_groups' => $certificateGroupRepo,
            'referral_agencies' => $referralAgencyRepo
        ];
    }

    public function index(Request $request)
    {
        $table = $request->input(self::TABLE_PARAM_NAME);
        if (empty($table)) {
            return $this->sendResponse(MasterdataService::getAllData(), trans('message.retrieve'));
        }

        if (!isset($this->repos[$table])) {
            return $this->sendError(trans('message.invalid_table').$table, 400);
        }

        $repos = $this->repos[$table];
        $repos->pushCriteria(new RequestCriteria($request));
        $repos->pushCriteria(new LimitOffsetCriteria($request));
        $result = $repos->all();

        return $this->sendResponse($result->toArray(), 'OK');
    }

    public function getMasterDataSearchPanel()
    {
        $data = [];
        $data['category_level3s'] = MasterdataService::getOneTable('category_level3s');
        $data['merits'] = MasterdataService::getOneTable('merits');
        $data['merit_groups'] = MasterdataService::getOneTable('merit_groups');
        $data['employment_modes'] = MasterdataService::getOneTable('employment_modes');
        return $this->sendResponse($data, 'OK');
    }

    public function store(CreateMasterdataAPIRequest $request)
    {
        $table = $request->input(self::TABLE_PARAM_NAME);
        if (empty($table)) {
            return $this->sendError(trans('message.required_table'), 400);
        }

        if (!isset($this->repos[$table])) {
            return $this->sendError(trans('message.invalid_table').$table, 400);
        }

        $input = $request->all();
        $repos = $this->repos[$table];
        $result = $repos->create($input);

        return $this->sendResponse($result->toArray(), trans('message.create'));
    }

    public function show(Request $request, $id)
    {
        $table = $request->input(self::TABLE_PARAM_NAME);
        if (empty($table)) {
            return $this->sendError(trans('message.required_table'), 400);
        }

        if (!isset($this->repos[$table])) {
            return $this->sendError(trans('message.invalid_table').$table, 400);
        }

        $repos = $this->repos[$table];
        $result = $repos->findWithoutFail($id);

        if (is_null($result)) {
            return $this->sendError(trans('message.unfound'), 404);
        }

        return $this->sendResponse($result, trans('message.retrieve'));
    }

    public function update(UpdateMasterdataAPIRequest $request, $id)
    {
        $table = $request->input(self::TABLE_PARAM_NAME);
        if (empty($table)) {
            return $this->sendError(trans('message.required_table'), 400);
        }

        if (!isset($this->repos[$table])) {
            return $this->sendError(trans('message.invalid_table').$table, 400);
        }

        $repos = $this->repos[$table];
        $record = $repos->findWithoutFail($id);
        $validator = Validator::make($request->all(), $repos->rules());
        if ($validator->fails()) {
           return Response::json(ResponseUtil::makeError($validator->getMessageBag()->toArray()), 400);
        }

        if (is_null($record)) {
            return $this->sendError(trans('message.unfound'), 404);
        }

        if (!method_exists($record, 'customUpdate')) {
            $input = $request->all();
            $record->update($input);
            event(new MasterdataChangedEvent());
            return $this->sendResponse($record, trans('message.update'));
        }

        $result = $record->customUpdate($request);
        if (!$result['success']) {
            return $this->sendError($result['message'], 404);
        }
        event(new MasterdataChangedEvent());
        return $this->sendResponse($record, trans('message.update'));
    }

    public function destroy(Request $request, $id)
    {
        $table = $request->input(self::TABLE_PARAM_NAME);
        if (empty($table)) {
            return $this->sendError(trans('message.required_table'), 400);
        }

        if (!isset($this->repos[$table])) {
            return $this->sendError(trans('message.invalid_table').$table, 400);
        }

        $repos = $this->repos[$table];
        $record = $repos->findWithoutFail($id);
        if (is_null($record)) {
            return $this->sendError(trans('message.data_not_exist'), 404);
        }

        if (!method_exists($record, 'customDestroy')) {
            $record->delete();
            return $this->sendResponse($id, trans('message.deletable'));
        }

        $result = $record->customDestroy();
        if (!$result['success']) {
            return $this->sendError($result['message'], 404);
        }

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function bulkUpdate(Request $request, $table)
    {
        $records = $request->all();
        foreach ($records as $record) {
            DB::table($table)->where('id', $record['id'])->update($record);
        }
        event(new MasterdataChangedEvent());

        return $this->sendResponse($records, trans('message.update'));
    }
}
