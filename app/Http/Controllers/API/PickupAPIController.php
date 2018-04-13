<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePickupAPIRequest;
use App\Http\Requests\API\UpdatePickupAPIRequest;
use App\Models\CategoryLevel2Pickup;
use App\Models\CategoryLevel3Pickup;
use App\Models\Pickup;
use App\Models\PickupMerit;
use App\Repositories\Criteria\BaseCriteria;
use App\Repositories\PickupRepository;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;

/**
 * Class PickupController
 * @package App\Http\Controllers\API
 */
class PickupAPIController extends AppBaseController
{
    /** @var  PickupRepository */
    private $pickupRepository;

    public function __construct(PickupRepository $pickupRepo)
    {
        $this->pickupRepository = $pickupRepo;
    }

    /**
     * Display a listing of the Pickup.
     * GET|HEAD /pickups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pickupRepository->pushCriteria(new BaseCriteria($request));
        $this->pickupRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pickups = $this->pickupRepository->paginate($request->input('limit'));

        return $this->sendResponse($pickups->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Pickup in storage.
     * POST /pickups
     *
     * @param CreatePickupAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePickupAPIRequest $request)
    {
        $input = $request->all();

        $pickups = $this->pickupRepository->create($input);

        return $this->sendResponse($pickups->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Pickup.
     * GET|HEAD /pickups/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Pickup $pickup */
        $pickup = $this->pickupRepository->findWithoutFail($id);
        if (empty($pickup)) {
            return $this->sendError(trans('message.unfound'));
        }

        $result = $this->addInfomation($pickup);

        return $this->sendResponse($result, trans('message.retrieve'));
    }

    public function addInfomation($pickup) {
        $result = $pickup->toArray();

        $result['category_level3s'] = DB::table("pickup_category_level3")
          ->join('pickups', 'pickup_category_level3.pickup_id', '=', 'pickups.id')
          ->select('pickup_category_level3.category_level3_id')
          ->where('pickups.id', $pickup->id)
          ->pluck('category_level3_id');

        $result['merits'] = DB::table("pickup_merit")
          ->join('pickups', 'pickup_merit.pickup_id', '=', 'pickups.id')
          ->select('pickup_merit.merit_id')
          ->where('pickups.id', $pickup->id)
          ->pluck('merit_id');

        return $result;
    }

    /**
     * Update the specified Pickup in storage.
     * PUT/PATCH /pickups/{id}
     *
     * @param  int $id
     * @param UpdatePickupAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePickupAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pickup $pickup */
        $pickup = $this->pickupRepository->findWithoutFail($id);

        if (empty($pickup)) {
            return $this->sendError(trans('message.unfound'));
        }

        $pickup = $this->pickupRepository->update($input, $id);
        $result = $this->addInfomation($pickup);
        return $this->sendResponse($result, trans('message.update'));
    }

    /**
     * Remove the specified Pickup from storage.
     * DELETE /pickups/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Pickup $pickup */
        $pickup = $this->pickupRepository->findWithoutFail($id);

        if (empty($pickup)) {
            return $this->sendError(trans('message.unfound'));
        }

        $pickup->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    /**
     * @param Request $request
     */
    public function downloadCsv(Request $request)
    {
        $this->pickupRepository->pushCriteria(new BaseCriteria($request));
        $this->pickupRepository->pushCriteria(new LimitOffsetCriteria($request));
        $jobs = $this->pickupRepository->all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(Utils::utf8ToSjis(\Schema::getColumnListing('pickups')));

        foreach ($jobs as $job) {
            $csv->insertOne(Utils::utf8ToSjis($job->toArray()));
        }

        $csv->output('pickups.csv');
    }
}
