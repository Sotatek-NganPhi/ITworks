<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateAdminAPIRequest;
use App\Http\Requests\API\UpdateAdminAPIRequest;
use App\Http\Services\AnalysisService;
use App\Http\Services\JobService;
use App\Repositories\AdminRepository;
use App\Repositories\Criteria\BaseCriteria;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AdminController
 * @package App\Http\Controllers\API
 */
class AdminAPIController extends AppBaseController
{
    /** @var  AdminRepository */
    private $AdminRepository;

    public function __construct(AdminRepository $AdminRepo)
    {
        $this->AdminRepository = $AdminRepo;
    }

    /**
     * Display a listing of the Admin.
     * GET|HEAD /Admins
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->AdminRepository->pushCriteria(new BaseCriteria($request));
        $this->AdminRepository->pushCriteria(new LimitOffsetCriteria($request));
        $Admins = $this->AdminRepository->paginate(Consts::PAGE_SIZE);

        return $this->sendResponse($Admins->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Admin in storage.
     * POST /Admins
     *
     * @param CreateAdminAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAdminAPIRequest $request)
    {
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $Admins = $this->AdminRepository->create($input);

        return $this->sendResponse($Admins->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Admin.
     * GET|HEAD /Admins/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        /** @var Admin $Admin */
        $this->AdminRepository->pushCriteria(new BaseCriteria($request));
        $Admin = $this->AdminRepository->findWithoutFail($id);

        if (empty($Admin)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($Admin->toArray(), trans('message.retrieve'));
    }

    /**
     * Update the specified Admin in storage.
     * PUT/PATCH /Admins/{id}
     *
     * @param  int $id
     * @param UpdateAdminAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdminAPIRequest $request)
    {
        $input = $request->all();
        if (isset($input['password'])) $input['password'] = bcrypt($input['password']);
        /** @var Admin $Admin */
        $Admin = $this->AdminRepository->findWithoutFail($id);

        if (empty($Admin)) {
            return $this->sendError(trans('message.unfound'));
        }

        $Admin = $this->AdminRepository->update($input, $id);

        return $this->sendResponse($Admin->toArray(), trans('message.retrieve'));
    }

    /**
     * Remove the specified Admin from storage.
     * DELETE /Admins/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Admin $Admin */
        $Admin = $this->AdminRepository->findWithoutFail($id);

        if (empty($Admin)) {
            return $this->sendError(trans('message.unfound'));
        }

        $Admin->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function getManagers(Request $request)
    {
        $this->AdminRepository->pushCriteria(new RequestCriteria($request));
        $Admins = $this->AdminRepository->all();

        return $this->sendResponse($Admins->toArray(), trans('message.retrieve'));
    }

    public function getStatisticalInHomePage()
    {
        $statisticalAccess = AnalysisService::getStatisticalAccessYesterday();
        $statistical = ["statisticalAccess" => $statisticalAccess];
        return $this->sendResponse($statistical, trans('message.retrieve'));
    }
}
