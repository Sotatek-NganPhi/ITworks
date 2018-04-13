<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateExpoAPIRequest;
use App\Http\Requests\API\UpdateExpoAPIRequest;
use App\Models\Expo;
use App\Repositories\ExpoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;

/**
 * Class ExpoController
 * @package App\Http\Controllers\API
 */

class ExpoAPIController extends AppBaseController
{
    /** @var  ExpoRepository */
    private $expoRepository;

    public function __construct(ExpoRepository $expoRepo)
    {
        $this->expoRepository = $expoRepo;
    }

    /**
     * Display a listing of the Expo.
     * GET|HEAD /expos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->expoRepository->pushCriteria(new BaseCriteria($request));
        $this->expoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $expos = $this->expoRepository->withCount(['reservations'])->paginate(Consts::PAGE_SIZE);
        return $this->sendResponse($expos->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Expo in storage.
     * POST /expos
     *
     * @param CreateExpoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateExpoAPIRequest $request)
    {
        $input = $request->all();

        $expos = $this->expoRepository->create($input);

        return $this->sendResponse($expos->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Expo.
     * GET|HEAD /expos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Expo $expo */
        $expo = $this->expoRepository->with(['regions'])->findWithoutFail($id);

        if (empty($expo)) {
            return $this->sendError(trans('message.unfound'));
        }

        $regions = $expo->regions
                        ->map(function ($region) {
                            return $region->id;
                        })
                        ->toArray();
        unset($expo->regions);
        $expo->regions = $regions;
        return $this->sendResponse($expo->toArray(), trans('message.retrieve'));
    }

    /**
     * Update the specified Expo in storage.
     * PUT/PATCH /expos/{id}
     *
     * @param  int $id
     * @param UpdateExpoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpoAPIRequest $request)
    {
        $input = $request->all();

        /** @var Expo $expo */
        $expo = $this->expoRepository->findWithoutFail($id);

        if (empty($expo)) {
            return $this->sendError(trans('message.unfound'));
        }

        $expo = $this->expoRepository->update($input, $id);

        return $this->sendResponse($expo->toArray(),trans('message.update'));
    }

    /**
     * Remove the specified Expo from storage.
     * DELETE /expos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Expo $expo */
        $expo = $this->expoRepository->findWithoutFail($id);

        if (empty($expo)) {
            return $this->sendError(trans('message.unfound'));
        }

        $expo->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }
}
