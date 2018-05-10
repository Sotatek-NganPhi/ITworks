<?php

namespace App\Http\Services;

use App\Consts;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Config;
use App\Models\Job;
use App\Models\Prefecture;
use App\Models\RailwayLine;
use App\Models\Region;
use App\Models\SpecialPromotion;
use App\Models\Salary;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Maatwebsite\Excel\Facades\Excel;
use League\Csv\Reader;
use Illuminate\Support\Facades\Schema;
use Storage;
use App\Utils;
use App\Http\Services\MasterdataService;
use App\Repositories\JobRepository;
use Exception;
use Illuminate\Support\Facades\Log;


// TODO: using masterdata cache to resolve the relationship when searching for jobs
class JobService
{
    private $jobRepository;

    public function __construct()
    {
        $this->jobRepository = app(JobRepository::class);
    }

    private $csvRules = ['fields_jp', 'mandatory', 'reference_table', 'fields', 'description', 'example'];

    public function importCsv($fileName, $imagePath, $uploadedImages)
    {
        $rules = $this->loadRule();
        $reader = Reader::createFromPath(Storage::disk('csv')->url($fileName));
        $rows = $reader->fetch();
        $count = 1;
        foreach ($rows as $row) {
            if ($count == 1) {
                $rules = $this->parseHeader($rules, $row);
            } elseif ($count == 2) {
                $count++;
                continue; //Japanese headers
            } else {
                $this->importRow($rules, $row, $count, $imagePath, $uploadedImages);
            }
            $count++;
        }
        return max($count - 3, 0);
    }

    private function importRow($rules, $row, $rowCount, $imagePath, $uploadedImages)
    {
        $data = [];
        $existingJob = $this->getExistingJob($rules, $row);
        foreach ($rules as $header => $rule) {
            if (property_exists($rule, 'index') && isset($row[$rule->index])) {
                $value = trim(Utils::toUtf8($row[$rule->index]));

                if (empty($value)) {
                    if ($rule->mandatory) {
                        throw new Exception("Missing mandatory field: " . $header . " at row " . $rowCount);
                    }
                    continue;
                }

                if ($rule->reference_table) {
                    $value = array_unique(explode("|", $value));
                }

                if (strpos($header, 'image') !== false) {
                    $value = $this->validateImage($header, $value, $uploadedImages, $rowCount, $existingJob, $imagePath);
                }

                $data[$rule->fields] = $value;
            }
        }
        $validator = Validator::make($data, $this->jobRepository->rules());

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (isset($data['id'])) {
            $this->jobRepository->update($data, $data['id']);
        } else {
            $this->jobRepository->create($data);
        }
    }

    private function getExistingJob($rules, $row)
    {
        if (!isset($rules['id'])) {
            return null;
        }
        if (!isset($row[$rules['id']->index])) {
            return null;
        }
        return Job::find($row[$rules['id']->index]);
    }

    private function validateImage($field, $imageName, $uploadedImages, $rowCount, $existingJob, $imagePath)
    {
        if ($existingJob && $existingJob->$field == $imageName) {
            return $imageName;
        }
        if (!in_array($imageName, $uploadedImages)) {
            throw new Exception("Image specified in csv file but hasn't been uploaded: " . $imageName . " at row " . $rowCount, 1);
        }
        if (!Utils::endsWith($imageName, ".jpg") && !Utils::endsWith($imageName, ".png")) {
            throw new Exception("Image format not supported (not .png or .jpg): " . $imageName . " at row " . $rowCount, 1);
        }
        return $imagePath . $imageName;
    }

    private function parseHeader($rules, $headers)
    {
        foreach ($headers as $key => $header) {
            $header = trim(Utils::toUtf8($header));
            if (array_key_exists($header, $rules)) {
                $rules[$header]->index = $key;
            } elseif ($header == 'id') {
                $rules['id'] = (object)['index' => $key, 'fields' => 'id', 'mandatory' => null, 'reference_table' => null];
            }
        }
        $missingColumns = [];
        foreach ($rules as $header => $rule) {
            if (!property_exists($rule, 'index')) {
                $missingColumns[] = $header;
            }
        }
        if (!empty($missingColumns)) {
            throw new Exception("CSV format incorrect: missing columns " . implode(', ', $missingColumns));
        }

        return $rules;
    }

    public function loadRule()
    {
        $path = storage_path('masterdata/20170701.xlsx');
        $headers = Excel::selectSheets('ex)job_csv_import')->load($path)->get($this->csvRules);
        $results = [];
        foreach ($headers as $header) {
            if (!$header->fields) {
                continue;
            }

            $results[trim($header->fields)] = $header;
        }
        return $results;
    }

    public function search($request, $keyRegion)
    {
        $limit = 10;
        $params = $request->all();
        if (isset($params["limit"])) {
            $limit = $params["limit"];
        }
        $query = DB::table("job_prefecture");
        $region = Region::getRegionByKey($keyRegion);
        $prefectureIds = Region::getPrefectureIds($region->id);
        $query->whereIn("job_prefecture.prefecture_id", $prefectureIds);
        if (isset($params["prefecture_id"]) && !is_null($params["prefecture_id"])) {
            $query->where("job_prefecture.prefecture_id", $params["prefecture_id"]);
        }

        if (isset($params["category_id"]) && !is_null($params["category_id"])) {
            $query->join("job_category_level3", "job_category_level3.job_id", "job_prefecture.job_id")
                ->where("job_category_level3.category_level3_id", $params["category_id"]);
        }

        $query->join('jobs', 'jobs.id', 'job_prefecture.job_id');

        if (isset($params["free_word"]) && !is_null($params["free_word"])) {
            $query->where(function ($query) use ($params) {
                $query->where("jobs.company_name", 'like', '%' . $params["free_word"] . '%')
                    ->orWhere("jobs.description", 'like', '%' . $params["free_word"] . '%');
            });
        }

        $sort = $request->sort;
        switch ($sort) {
            case "new":
                $jobs = $query->select("jobs.*")->orderBy('jobs.created_at', 'desc')->distinct()->paginate($limit, ['jobs.id']);
                break;
            case "hot":
                $jobs = $this->getAttentionJobs($prefectureIds, 10, true);
                break;
            case "end":
                $jobs = $query->select("jobs.*")->orderBy('jobs.post_end_date', 'asc')->distinct()->paginate($limit, ['jobs.id']);
                break;
            default:
                $jobs = $query->select("jobs.*")->orderBy('jobs.created_at')->distinct()->paginate($limit, ['jobs.id']);
        }

        $jobs = $this->addRelatedInfo($jobs, $prefectureIds);
        return $this->formatPaginate($jobs, $request);
    }

    public function getInfoConditionsSearch(Request $request)
    {
        $inputs = $request->all();
        $conditions = [];
        if (isset($inputs["category_id"]) && !is_null($inputs["category_id"])) {
            $category = CategoryLevel3::findOneById($inputs["category_id"]);
            $conditions[] = [
                "key" => "category",
                "display" => "職種",
                "text" => [$category->name],
            ];
        }

        if (isset($inputs["free_word"]) && !is_null($inputs["free_word"])) {
            $conditions[] = [
                "key" => "free_word",
                "display" => "フリーワード",
                "text" => [$inputs["free_word"]],
            ];
        }

        if (isset($inputs["prefecture_id"]) && !is_null($inputs["prefecture_id"])) {
            $prefecture = Prefecture::findOneById($inputs["prefecture_id"]);
            $text = [$prefecture->name];
            $conditions[] = [
                "key" => "municipality",
                "display" => "市区町村",
                "text" => $text,
            ];
        }

        return $conditions;
    }

    private function addRelatedInfo($jobs, $prefectureIds)
    {
        $jobIds = $jobs->pluck('id');

        $prefectures = DB::table('job_prefecture')
            ->select('job_id', 'prefecture_id')
            ->whereIn('job_id', $jobIds)
            ->whereIn('job_prefecture.prefecture_id', $prefectureIds)
            ->get();

        $categories = DB::table('job_category_level3')
            ->select('job_id', 'category_level3_id')
            ->whereIn('job_id', $jobIds)
            ->get();

        $salaries = DB::table('job_salary')
            ->select('job_id', 'salary_id')
            ->whereIn('job_id', $jobIds)
            ->get();

        $relatedInfo = [
            'prefectures' => $prefectures->groupBy('job_id')->toArray(),
            'categories' => $categories->groupBy('job_id')->toArray(),
            'salaries' => $salaries->groupBy('job_id')->toArray(),
        ];

        $prefectures = MasterdataService::getOneTable('prefectures');
        $salaries = MasterdataService::getOneTable('salaries');
        $category_level3s = MasterdataService::getOneTable('category_level3s');

        foreach ($jobs as $job) {
            $job->prefectures = [];
            $job->categories = [];
            $job->salaries = [];

            if (isset($relatedInfo['prefectures'][$job->id])) {
                $prefectureIds = collect($relatedInfo['prefectures'][$job->id])->slice(0, 2)->pluck('prefecture_id')->toArray();
                $job->prefectures = $prefectures->whereIn('id', $prefectureIds);
            }

            if (isset($relatedInfo['categories'][$job->id])) {
                $categoryIds = collect($relatedInfo['categories'][$job->id])->slice(0, 2)->pluck('category_id')->toArray();
                $job->categories = $category_level3s->whereIn('id', $categoryIds);
            }

            if (isset($relatedInfo['salaries'][$job->id])) {
                $salaryIds = collect($relatedInfo['salaries'][$job->id])->slice(0, 2)->pluck('salary_id')->toArray();
                $job->salaries = $salaries->whereIn('id', $salaryIds);
            }
        }

        return $jobs;
    }

    public function formatPaginate($results, $request)
    {
        $data = $results->toArray();
        $floorParam = $request->floor;
        $ceilParam = $request->ceil;

        $data["path"] = preg_replace('/page=[^&]+(&|$)/', '', $request->fullUrl());
        $data["path"] = preg_replace('/ceil=[^&]+(&|$)/', '', $data["path"]);
        $data["path"] = preg_replace('/floor=[^&]+(&|$)/', '', $data["path"]);
        $data["path"] = preg_replace('/&sort=[^&]+(&|$)/', '', $data["path"]);

        if ($request->session()->has('path')) {
            $path = $request->session()->get('path');
            if ($path != $data["path"]) {
                $request->session()->regenerate();
            }
        }

        $page_prev = $request->session()->get('page_prev');

        $ceil_prev = $request->session()->get('ceil_prev');
        $floor_prev = $request->session()->get('floor_prev');


        if ($ceil_prev > $data["current_page"] && $floor_prev < $data["current_page"]) {
            $data["ceil"] = $ceil_prev;
            $data["floor"] = $floor_prev;
        } else {
            $data["ceil"] = ceil($data["current_page"] / 10) * 10;
            $data["floor"] = $data["ceil"] > 9 ? $data["ceil"] - 9 : 1;

            if ($data["ceil"] == $data["current_page"]) {
                $data["ceil"] += 1;
                $data["floor"] = $data["ceil"] - 9;
            }

            if ($data["floor"] > 2 && ($data["floor"] == $data["current_page"])) {
                $data["floor"] -= 1;
                $data["ceil"] = $data["floor"] + 9;
            }

            if ($data["ceil"] > $data["last_page"]) {
                $data["ceil"] = $data["last_page"];
                $data["floor"] = $data["ceil"] > 9 ? $data["ceil"] - 9 : 1;
            }
        }

        if (isset($ceilParam)) {
            $data["floor"] = $page_prev;
            $data["ceil"] = $data["floor"] + 9;
            if ($data["ceil"] > $data["last_page"]) {
                $data["ceil"] = $data["last_page"];
                $data["floor"] = $data["ceil"] - 9;
            }
        } elseif (isset($floorParam)) {
            if ($page_prev >= 10) {
                $data["ceil"] = $page_prev;
                $data["floor"] = $data["ceil"] - 9;
            } else {
                $data["ceil"] = $data["last_page"] > 10 ? 10 : $data["last_page"];
                $data["floor"] = 1;
            }
        }

        $request->session()->put('page_prev', $data["current_page"]);
        $request->session()->put('ceil_prev', $data["ceil"]);
        $request->session()->put('floor_prev', $data["floor"]);

        if (!$request->session()->has('path')) {
            $request->session()->put('path', $data["path"]);
        }
        return $data;
    }

    public function show($id)
    {
        $job = Job::find($id);
        if (is_null($job)) {
            return null;
        }
        $job["company"] = Company::find($job->company_id);
        return $job;
    }

    public function getAttentionJobs($prefectureIds, $limit = 10, $isPaginated = false)
    {
        $CACHE_KEY = 'hotJobs?'
            . 'prefectureIds=' . (implode('|', $prefectureIds))
            . '&limit=' . $limit
            . '&isPaginated=' . $isPaginated;
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            return Cache::get($CACHE_KEY);
        }

        $query = DB::table('jobs')->select('jobs.*', DB::raw('sum(views) as viewCount'))
            ->join('job_prefecture', 'job_prefecture.job_id', 'jobs.id')
            ->join('job_counters', 'jobs.id', 'job_counters.job_id')
            ->whereIn('job_prefecture.prefecture_id', $prefectureIds)
            ->where('view_date', '>', Carbon::now()->subDay(7))
            ->groupBy('jobs.id')
            ->orderBy('viewCount', 'desc');

        if ($isPaginated) {
            $jobs = $query->paginate($limit);
        } else {
            $jobs = $query->limit($limit)->get();
        }

        Cache::put($CACHE_KEY, $jobs, $CACHE_DURATION);
        return $jobs;
    }

    public function getJobCounts($keyRegion, $prefectureIds)
    {
        $CACHE_KEY = 'jobCounts?'
            . 'keyRegion=' . $keyRegion
            . '&prefectureIds=' . (implode('|', $prefectureIds));
        $CACHE_DURATION = 5; // Minutes

        if (Cache::has($CACHE_KEY)) {
            $result = Cache::get($CACHE_KEY);
            return $result;
        }

        $result = [];

        Cache::put($CACHE_KEY, $result, $CACHE_DURATION);
        return $result;
    }

    public function getJobCountsByPrefectures($keyRegion, $prefectureIds, $limit = 6)
    {
        $results = [];
        $jobCounts = Prefecture::select("prefectures.id as prefecture_id", DB::raw("count(distinct job_prefecture.job_id) as count"))
            ->whereIn('prefectures.id', $prefectureIds)
            ->leftJoin("job_prefecture", "job_prefecture.prefecture_id", "prefectures.id")
            ->groupBy("prefectures.id")
            ->orderBy("count", "desc")
            ->limit($limit)
            ->get();

        $prefectures = Prefecture::getAll()->groupBy('id')->toArray();
        foreach ($jobCounts as $jobCount) {
            $prefectureId = $jobCount['prefecture_id'];
            $prefecture = (array)($prefectures[$prefectureId][0]);
            array_push($results, [
                'name' => $prefecture['name'],
                'jobCount' => $jobCount['count'],
                'link' => route('search', $keyRegion) . '?prefecture_id=' . $prefectureId
            ]);
        }

        return ['都道府県で探す' => $results];
    }


    public static function getStatisticalJob()
    {
        $today = Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString();
        $statisticalJob = Job::select(DB::raw("count(CASE WHEN original_state = '0' THEN 1 END) as totalInvalid"),
            DB::raw("count(CASE WHEN post_end_date < '$today' AND  original_state = '1' THEN 1 END) as totalExpired "),
            DB::raw("count(*) as total"))->first();
        return $statisticalJob;
    }

    public function getTotalJobNewInDay()
    {
        return Job::whereDate('created_at', Carbon::now(Consts::TIME_ZONE_JAPAN)->toDateString())->count();
    }

    protected function execQuerySearchJob(Request $request, $query)
    {
        $limit = $request->input('limit', 10);
        $query = $this->appendQuerySortJob($request, $query);
        return $query->select("jobs.*")->distinct()->paginate($limit, ['jobs.id']);
    }

    protected function appendQuerySortJob(Request $request, $query)
    {
        $sort = $request->input('sort');
        switch ($sort) {
            case "new":
                $query = $query->orderBy('jobs.id', 'desc');
                break;
            case "end":
                $query = $query->orderBy('jobs.post_end_date', 'asc');
                break;
            default:
                $query = $query->orderBy('jobs.id');
        }
        return $query;
    }

    protected function buildQuerySearchJob(Request $request)
    {
        $query = DB::table("jobs");
        if (!empty($request->input('category'))) {
            $query->join( DB::raw("(select * from job_category_level3 where job_category_level3.category_level3_id = '{$request->input('category')}') as category_level3"), "category_level3.job_id", "jobs.id");
        }

        if (!empty($request->input('free_word'))) {
            $freeWord = urldecode($request->input('free_word'));
            $query->where(function ($query) use ($freeWord) {
                $query->where("jobs.company_name", 'like', '%' . $freeWord . '%')
                    ->orWhere("jobs.description", 'like', '%' . $freeWord . '%');
            });
        }
        return $query;
    }
}
