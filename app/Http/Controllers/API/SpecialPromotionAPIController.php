<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateSpecialPromotionAPIRequest;
use App\Http\Requests\API\UpdateSpecialPromotionAPIRequest;
use App\Models\SpecialPromotion;
use App\Repositories\SpecialPromotionRepository;
use App\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Repositories\Criteria\BaseCriteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Class SpecialPromotionController
 * @package App\Http\Controllers\API
 */

class SpecialPromotionAPIController extends AppBaseController
{
    /** @var  SpecialPromotionRepository */
    private $specialPromotionRepository;

    public function __construct(SpecialPromotionRepository $specialPromotionRepo)
    {
        $this->specialPromotionRepository = $specialPromotionRepo;
    }

    public function downloadCsv(Request $request)
    {
        $this->specialPromotionRepository->pushCriteria(new BaseCriteria($request));
        $this->specialPromotionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $promotions = $this->specialPromotionRepository->all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $specialPromotions = $this->additionListInfo($promotions);
        $headers = \Schema::getColumnListing('special_promotions');
        array_push($headers, "regions");
        $csv->insertOne(Utils::utf8ToSjis($headers));

        foreach ($specialPromotions as $promotion) {
            $csv->insertOne(Utils::utf8ToSjis($promotion->toArray()));
        }

        $csv->output('special_promotions.csv');
    }

    /**
     * Display a listing of the SpecialPromotion.
     * GET|HEAD /specialPromotions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->specialPromotionRepository->pushCriteria(new BaseCriteria($request));
        $this->specialPromotionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $promotions = $this->specialPromotionRepository->paginate($request->input('limit'));
        return $this->sendResponse($promotions->toArray(),  trans('message.retrieve'));
    }

    private function additionListInfo($promotions)
    {
        $promotionIdList = $promotions->pluck('id');
        $promotionRegions = DB::table("special_promotion_region")->whereIn('special_promotion_id', $promotionIdList)
            ->join('regions', 'regions.id', '=', 'special_promotion_region.region_id')
            ->select('special_promotion_region.special_promotion_id', 'regions.id')
            ->get();
        $promotionRegions = $promotionRegions->groupBy('special_promotion_id');
        $specialPromotions = $promotions->map(function ($value) use ($promotionRegions) {
            $promotionId = $value->id;
            if (isset($promotionRegions[$promotionId])) {
                $region = $promotionRegions[$promotionId];
                $value->regions = $region->pluck('id');
            }
            return $value;
        });
        return $specialPromotions;
    }

    /**
     * Store a newly created SpecialPromotion in storage.
     * POST /specialPromotions
     *
     * @param CreateSpecialPromotionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSpecialPromotionAPIRequest $request)
    {
        $input = $request->all();

        $specialPromotions = $this->specialPromotionRepository->create($input);

        $specialPromotions->regions()->sync($input['regions']);

        $specialPromotions->jobs()->sync($input['jobs']);

        $specialPromotions = $this->addInfo($specialPromotions);

        return $this->sendResponse($specialPromotions->toArray(),  trans('message.save'));
    }

    /**
     * Display the specified SpecialPromotion.
     * GET|HEAD /specialPromotions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SpecialPromotion $specialPromotion */
        $promotion = $this->specialPromotionRepository->findWithoutFail($id);

        if (empty($promotion)) {
            return $this->sendError( trans('message.unfound'));
        }

        $specialPromotion = $this->addInfo($promotion);

        return $this->sendResponse($specialPromotion->toArray(),  trans('message.retrieve'));
    }

    private function addInfo($specialPromotion)
    {
        //Regions
        $promotionRegions = DB::table("special_promotion_region")->where('special_promotion_id', $specialPromotion->id)
            ->select('region_id')
            ->get();

        $specialPromotion->regions = $promotionRegions->pluck('region_id');

        //Jobs
        $promotionJobs = DB::table('job_special')
                            ->where('special_promotion_id', $specialPromotion->id)
                            ->select('job_id')
                            ->get();
        $specialPromotion->jobs = $promotionJobs->pluck('job_id');

        return $specialPromotion;
    }

    /**
     * Update the specified SpecialPromotion in storage.
     * PUT/PATCH /specialPromotions/{id}
     *
     * @param  int $id
     * @param UpdateSpecialPromotionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSpecialPromotionAPIRequest $request)
    {
        $input = $request->all();

        /** @var SpecialPromotion $specialPromotion */
        $specialPromotion = $this->specialPromotionRepository->findWithoutFail($id);

        if (empty($specialPromotion)) {
            return $this->sendError( trans('message.unfound'));
        }

        $specialPromotion = $this->specialPromotionRepository->update($input, $id);

        $specialPromotion->regions()->sync($input['regions']);

        $specialPromotion->jobs()->sync($input['jobs']);

        $specialPromotion = $this->addInfo($specialPromotion);

        return $this->sendResponse($specialPromotion->toArray(),  trans('message.update'));
    }

    /**
     * Remove the specified SpecialPromotion from storage.
     * DELETE /specialPromotions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SpecialPromotion $specialPromotion */
        $specialPromotion = $this->specialPromotionRepository->findWithoutFail($id);

        if (empty($specialPromotion)) {
            return $this->sendError(trans('message.unfound'));
        }

        $specialPromotion->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }
}
