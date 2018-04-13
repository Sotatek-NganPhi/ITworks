<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateJobAPIRequest;
use App\Http\Requests\API\UpdatejobAPIRequest;
use App\Http\Services\JobService;
use App\Models\Job;
use App\Models\JobCounter;
use App\Models\Prefecture;
use App\Repositories\Criteria\BaseCriteria;
use App\Repositories\JobRepository;
use App\Utils;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use League\Csv\Writer;
use Response;
use SplTempFileObject;

/**
 * Class jobController
 * @package App\Http\Controllers\API
 */
class JobAPIController extends AppBaseController
{
    /** @var  jobRepository */
    private $jobRepository;
    private $jobService;

    public function __construct(JobRepository $jobRepo)
    {
        $this->jobRepository = $jobRepo;
        $this->jobService = new JobService();
    }

    /**
     * Display a listing of the job.
     * GET|HEAD /jobs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $jobIds = [];
        if ($request['ids']) {
            $jobIds = explode(",", $request['ids']);
        } else if ($request['similarWith']) {
            $jobIds = $this->getSimilarJobs(explode(',', $request['similarWith']));
        }

        $this->jobRepository->pushCriteria(new BaseCriteria($request));
        $this->jobRepository->pushCriteria(new LimitOffsetCriteria($request));

        if (count($jobIds) > 0) {
            $jobs = $this->jobRepository->findWhereIn('id', $jobIds);
            return $this->sendResponse($jobs->toArray(), trans('message.retrieve'));
        }
        $manager = Auth::guard(Consts::GUARD_MANAGER)->user();
        if($manager->type != Consts::TYPE_SYS_ADMIN) {
            if($manager->agency_id == 0) {
                return $this->sendResponse(null, trans('message.retrieve'));
            }
            $request->merge(['agency' => $manager->agency_id]);
        }
        $jobs = $this->jobRepository->paginate($request->input('limit'));
        return $this->sendResponse($jobs->toArray(), trans('message.retrieve'));
    }

    public function applicantJob(Request $request)
    {
        $manager = Auth::guard(Consts::GUARD_MANAGER)->user();
        $this->jobRepository->with(['company'])->withCount('applicants')->viewCount()->pushCriteria(new BaseCriteria($request));
        $this->jobRepository->pushCriteria(new LimitOffsetCriteria($request));
        $jobRepository = $this->jobRepository;
        if($manager->type != Consts::TYPE_SYS_ADMIN) {
            if($manager->company_id == 0) {
                return $this->sendResponse(null, trans('message.retrieve'));
            }
            $jobRepository->scopeQuery(function ($query) use ($request, $manager) {
                return $query->where('company_id', $manager->company_id);
            });
        }
        $jobs = $jobRepository->paginate($request->input('limit'));
        return $this->sendResponse($jobs->toArray(), trans('message.retrieve'));
    }

    public function importCsv(Request $request)
    {
        $file = $request->file;
        if (!is_file($file)) {
            return $this->sendError(trans('message.not_file'));
        }

        $microtime = str_replace(".", "", microtime(true));
        $fileName = $microtime . '.' . $file->getClientOriginalExtension();
        Storage::disk('csv')->put($fileName, File::get($file));

        DB::beginTransaction();
        try {
            $outputFolder = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $microtime;
            $uploadedImages = [];
            $images = $request->images;
            if (is_file($images)) {
                $zipFileName = $microtime . '.' . $images->getClientOriginalExtension();
                Storage::disk('csv')->put($zipFileName, File::get($images));
                $uploadedImages = Utils::unzip(Storage::disk('csv')->url($zipFileName), $outputFolder);
            }
            $count = $this->jobService->importCsv($fileName, Storage::disk('public')->url($microtime) . DIRECTORY_SEPARATOR, $uploadedImages);
            DB::commit();

            if ($count == 0) {
                $this->sendError(trans('message.import_fail'));
            }

            return $this->sendResponse($count, $count . trans('message.import'));
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created job in storage.
     * POST /jobs
     *
     * @param CreateJobAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateJobAPIRequest $request)
    {
        $input = $request->all();

        $jobs = $this->jobRepository->create($input);

        $jobs->counters()->save(new JobCounter);

        return $this->sendResponse($jobs->toArray(), trans('message.save'));
    }

    /**
     * Display the specified job.
     * GET|HEAD /jobs/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Request $request, $id)
    {
        /** @var job $job */
        $job = $this->jobRepository->findWithoutFail($id);

        if (empty($job)) {
            return $this->sendError(trans('message.unfound'));
        }

        // TODO: refactor this using BaseRepository?
        $result = $job->toArray();
        $result['company'] = $job->company()->value('id');
        $result['categoryLevel3s'] = $job->categoryLevel3s()->pluck('category_level3_id');
        $result['currentSituations'] = $job->currentSituations()->pluck('current_situation_id');
        $result['merits'] = $job->merits()->pluck('merit_id');
        $result['salaries'] = $job->salaries()->pluck('salary_id');
        $result['employmentModes'] = $job->employmentModes()->pluck('employment_mode_id');
        $result['prefectures'] = $job->prefectures()->pluck('prefecture_id');
        $result['wards'] = $job->wards()->pluck('ward_id');
        $result['workingShifts'] = $job->workingShifts()->pluck('working_shift_id');
        $result['workingDays'] = $job->workingDays()->pluck('working_day_id');
        $result['workingHours'] = $job->workingHours()->pluck('working_hour_id');
        $result['workingPeriods'] = $job->workingPeriods()->pluck('working_period_id');
        $result['routes'] = $job->routes()->pluck('line_station_id');


        return $this->sendResponse($result, trans('message.retrieve'));
    }

    /**
     * Update the specified job in storage.
     * PUT/PATCH /jobs/{id}
     *
     * @param  int $id
     * @param UpdatejobAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatejobAPIRequest $request)
    {
        $input = $request->all();

        /**
         * Update job instance
         */
        $job = $this->jobRepository->findWithoutFail($id);

        if (empty($job)) {
            return $this->sendError(trans('message.unfound'));
        }

        $job = $this->jobRepository->update($input, $id);

        return $this->sendResponse($job->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified job from storage.
     * DELETE /jobs/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var job $job */

        $job = $this->jobRepository->findWithoutFail($id);

        if (empty($job)) {
            return $this->sendError(trans('message.unfound'));
        }
        $job->categoryLevel3s()->delete();
        $job->counters()->delete();
        $job->currentSituations()->delete();
        $job->employmentModes()->delete();
        $job->merits()->delete();
        $job->prefectures()->delete();
        $job->routes()->delete();
        $job->salaries()->delete();
        $job->wards()->delete();
        $job->workingDays()->delete();
        $job->workingHours()->delete();
        $job->workingPeriods()->delete();
        $job->workingShifts()->delete();
        $job->applicants()->delete();
        $job->specialPromotions()->delete();
        $job->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function downloadCsv(Request $request)
    {
        $fieldsEn = ['id'];
        $fieldsJp = ['仕事ID'];
        $rules = $this->jobService->loadRule();

        $relations = [];
        foreach ($rules as $header => $rule) {
            $fieldsEn[] = Utils::utf8ToSjis($header);
            $fieldsJp[] = $rule->fields_jp;
            if ($rule->reference_table) {
                $relations[] = $header;
            }
        }

        $this->jobRepository->pushCriteria(new BaseCriteria($request));
        $this->jobRepository->pushCriteria(new LimitOffsetCriteria($request));
        $jobs = $this->jobRepository->with($relations)->all();

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne(Utils::utf8ToSjis($fieldsEn));
        $csv->insertOne(Utils::utf8ToSjis($fieldsJp));

        foreach ($jobs as $job) {
            $row = [$job->id];
            foreach ($rules as $header => $rule) {
                $value = $job->$header;
                if (!$value) {
                    $row[] = '';
                    continue;
                }

                if ($rule->reference_table) {
                    if (!$value->isEmpty()) {
                        $value = $value->pluck('id');
                    }

                    $value = implode('|', $value->toArray());
                }
                $row[] = Utils::utf8ToSjis($value);
            }
            $csv->insertOne($row);
        }

        $csv->output('jobs_to_update.csv');
    }

    public function getJobsQualified(Request $request) {
        $querySearch = $request->input('query');
        $regionIds = $request->input('regionIds');
        if (!count($regionIds)) return $this->sendResponse([], trans('message.update'));
        $prefectures = Prefecture::findWhereIn('region_id', $regionIds)->keyBy('id');
        $jobs = Job::select('jobs.id as id','work_no','platform_urgent')
          ->join('job_prefecture', 'jobs.id', '=', 'job_prefecture.job_id')
          ->whereIn('job_prefecture.prefecture_id', $prefectures->keys())
          ->where('work_no', 'like', '%'.$querySearch.'%')
          ->with('prefectures')
          ->distinct()
          ->limit(50)
          ->get()
          ->transform(function ($job) {
              $job->regions = $job['prefectures']->unique('region_id')->pluck('region_id');
              return $job;
          });
        return ($jobs);
    }

    public function updateUrgentJobs(Request $request)
    {
        $add_job_ids = $request['add_job_ids'];
        $del_job_ids = $request['del_job_ids'];

        if (count($add_job_ids) > 0) {
            Job::whereIn('id', $add_job_ids)
                ->update(['platform_urgent' =>  Consts::JOB_URGENT_VALID ]);
        }

        if (count($del_job_ids) > 0) {
            Job::whereIn('id', $del_job_ids)
                ->update(['platform_urgent' => Consts::JOB_URGENT_INVALID]);
        }

        return $this->sendResponse(true, trans('message.update'));
    }

    public function getUrgentJobs(Request $request) {
        $regionId = $request->input('regionId');
        $prefectureIds = Prefecture::findWhere('region_id', $regionId)->pluck('id');
        $jobs = Job::selectRaw('jobs.id as id, work_no, platform_urgent')
          ->join('job_prefecture', 'jobs.id', '=', 'job_prefecture.job_id')
          ->whereIn('job_prefecture.prefecture_id', $prefectureIds)
          ->distinct()
          ->get();
        return $this->sendResponse($jobs, trans('message.update'));
    }

    public function getJobsWithIds(Request $request) {
        $listId = $request->all();
        $jobs = Job::select('jobs.id as id','work_no','platform_urgent')
          ->whereIn('jobs.id',$listId)
          ->with('prefectures')
          ->get()->transform(function ($job) {
              $job->regions = $job['prefectures']->unique('region_id')->pluck('region_id');
              return $job;
          });
        return $jobs;
    }

    public function getSimilarJobs($ids)
    {
        $result = [];

        $companyIds = DB::table('jobs')
            ->select('company_id')
            ->whereIn('id', $ids)
            ->distinct()
            ->get()
            ->pluck('company_id')
            ->toArray();
        $jobIds = DB::table('jobs')
            ->select('id')
            ->whereIn('company_id', $companyIds)
            ->limit(10)
            ->get()
            ->pluck('job_id')
            ->toArray();
        $result = array_merge($result, $jobIds);

        $categoryIds = DB::table('job_category_level3')
            ->select('category_level3_id')
            ->whereIn('job_id', $ids)
            ->distinct()
            ->get()
            ->pluck('category_level3_id')
            ->toArray();
        $jobIds = DB::table('job_category_level3')
            ->select('job_id')
            ->whereIn('category_level3_id', $categoryIds)
            ->limit(10)
            ->get()
            ->pluck('job_id')
            ->toArray();
        $result = array_merge($result, $jobIds);

        $prefectureIds = DB::table('job_prefecture')
            ->select('prefecture_id')
            ->whereIn('job_id', $ids)
            ->distinct()
            ->get()
            ->pluck('prefecture_id')
            ->toArray();
        $jobIds = DB::table('job_prefecture')
            ->select('job_id')
            ->whereIn('prefecture_id', $prefectureIds)
            ->limit(10)
            ->get()
            ->pluck('job_id')
            ->toArray();
        $result = array_merge($result, $jobIds);

        return $result;
    }

    public function loadRules()
    {
        $rules = $this->jobService->loadRule();
        return $this->sendResponse($rules, trans('message.retrieve'));
    }
}

