<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSocialProviderAPIRequest;
use App\Http\Requests\API\UpdateSocialProviderAPIRequest;
use App\Models\SocialProvider;
use App\Repositories\SocialProviderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Consts;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SocialProviderController
 * @package App\Http\Controllers\API
 */

class SocialProviderAPIController extends AppBaseController
{
    /** @var  SocialProviderRepository */
    private $socialProviderRepository;

    public function __construct(SocialProviderRepository $socialProviderRepo)
    {
        $this->socialProviderRepository = $socialProviderRepo;
    }

    /**
     * Display a listing of the SocialProvider.
     * GET|HEAD /socialProviders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->socialProviderRepository->pushCriteria(new RequestCriteria($request));
        $this->socialProviderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $socialProviders = $this->socialProviderRepository->all();

        return $this->sendResponse($socialProviders->toArray(),  trans('message.retrieve'));
    }

    /**
     * Store a newly created SocialProvider in storage.
     * POST /socialProviders
     *
     * @param CreateSocialProviderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSocialProviderAPIRequest $request)
    {
        $input = $request->all();

        $socialProviders = $this->socialProviderRepository->create($input);

        return $this->sendResponse($socialProviders->toArray(),  trans('message.save'));
    }

    /**
     * Display the specified SocialProvider.
     * GET|HEAD /socialProviders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SocialProvider $socialProvider */
        $socialProvider = $this->socialProviderRepository->findWithoutFail($id);

        if (empty($socialProvider)) {
            return $this->sendError( trans('message.unfound'));
        }

        return $this->sendResponse($socialProvider->toArray(),  trans('message.retrieve'));
    }

    /**
     * Update the specified SocialProvider in storage.
     * PUT/PATCH /socialProviders/{id}
     *
     * @param  int $id
     * @param UpdateSocialProviderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSocialProviderAPIRequest $request)
    {
        $input = $request->all();

        /** @var SocialProvider $socialProvider */
        $socialProvider = $this->socialProviderRepository->findWithoutFail($id);

        if (empty($socialProvider)) {
            return $this->sendError( trans('message.unfound'));
        }

        $socialProvider = $this->socialProviderRepository->update($input, $id);

        return $this->sendResponse($socialProvider->toArray(),  trans('message.update'));
    }

    /**
     * Remove the specified SocialProvider from storage.
     * DELETE /socialProviders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SocialProvider $socialProvider */
        $socialProvider = $this->socialProviderRepository->findWithoutFail($id);

        if (empty($socialProvider)) {
            return $this->sendError(trans('message.unfound'));
        }

        $socialProvider->delete();

        return $this->sendResponse($id,trans('message.deletable'));
    }
}
