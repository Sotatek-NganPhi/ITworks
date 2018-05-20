<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateCompanyAPIRequest;
use App\Http\Requests\API\UpdateCompanyAPIRequest;
use App\Models\Company;
use App\Models\Job;
use App\Repositories\CompanyRepository;
use App\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Mail;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;
use View;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;


/**
 * Class CompanyController
 * @package App\Http\Controllers\API
 */

class CompanyAPIController extends AppBaseController
{
    /** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Company.
     * GET|HEAD /companies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->companyRepository->pushCriteria(new BaseCriteria($request));
        $this->companyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $companies = $this->companyRepository->paginate($request->input('limit'));
        return $this->sendResponse($companies->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Company in storage.
     * POST /companies
     *
     * @param CreateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyAPIRequest $request)
    {
        $input = $request->all();

        $companies = $this->companyRepository->create($input);

        return $this->sendResponse($companies->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Company.
     * GET|HEAD /companies/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        /** @var Company $company */
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($company->toArray(), trans('message.retrieve'));
    }

    /**
     * Update the specified Company in storage.
     * PUT/PATCH /companies/{id}
     *
     * @param  int $id
     * @param UpdateCompanyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Company $company */
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError(trans('message.unfound'));
        }

        $company = $this->companyRepository->update($input, $id);

        return $this->sendResponse($company->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified Company from storage.
     * DELETE /companies/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Company $company */
       
        if(!isset($job)) {
            $company = $this->companyRepository->findWithoutFail($id);

            if (empty($company)) {
                return $this->sendError(trans('message.unfound'));
            }
            $company->delete();

            return $this->sendResponse($id,trans('message.deletable'));
        }
        return $this->sendError(trans('message.in_use'));
    }

    public function sendMail(Request $request)
    {
        Mail::to(['email' => $request['email']])
            ->queue(new \App\Mail\Company($request->all()));
        return $this->sendResponse(null, trans('message.send_mail'));
    }

    public function getCompanies(Request $request)
    {
        $this->companyRepository->pushCriteria(new BaseCriteria($request));
        $companies = $this->companyRepository->all();

        return $this->sendResponse($companies->toArray(), trans('message.retrieve'));
    }
}
