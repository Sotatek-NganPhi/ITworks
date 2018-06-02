<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateApplicantAPIRequest;
use App\Http\Requests\API\UpdateApplicantAPIRequest;
use App\User;
use App\Mail\ApplicationToCandidate;
use App\Mail\ApplicationToEmployer;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Models\Job;
use App\Repositories\ApplicantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Jenssegers\Agent\Agent;
use App\Repositories\Criteria\BaseCriteria;
use Response;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ApplicantController
 * @package App\Http\Controllers\API
 */

class ApplicantAPIController extends AppBaseController
{
    /** @var  ApplicantRepository */
    private $applicantRepository;

    public function __construct(ApplicantRepository $applicantRepo)
    {
        $this->applicantRepository = $applicantRepo;
    }

    /**
     * Display a listing of the Applicant.
     * GET|HEAD /applicants
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {   
        $this->applicantRepository->pushCriteria(new BaseCriteria($request));
        $this->applicantRepository->pushCriteria(new LimitOffsetCriteria($request));
        $applicantRepository = $this->applicantRepository;
        $manager = Auth::guard(Consts::GUARD_MANAGER)->user();
        if($manager->type != Consts::TYPE_SYS_ADMIN) {
            if($manager->company_id == 0) {
                return $this->sendResponse(null, trans('message.retrieve'));
            }
            $applicantRepository->scopeQuery(function ($query) use ($request, $manager) {
                return $query->join('jobs', 'jobs.id', 'applicants.job_id')
                    ->where('jobs.company_id', $manager->company_id);
            });
        }
        $applicants = $applicantRepository->paginate($request->input('limit'));

        return $this->sendResponse($applicants->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Applicant in storage.
     * POST /applicants
     *
     * @param CreateApplicantAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateApplicantAPIRequest $request)
    {
        $inputs = $request->all();
        $applicants = $this->applicantRepository->create($inputs);

        $job = Job::find($inputs['job_id']);

        // TODO: do we need to send mail to candidate?
        // Mail::to(['email' => $inputs['email']])
        //     ->queue(new ApplicationToCandidate($inputs));

        Mail::to($job['email_receive_applicant'])
            ->send(new ApplicationToEmployer($job, $applicants));

        return $this->sendResponse($applicants->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Applicant.
     * GET|HEAD /applicants/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Applicant $applicant */
        $applicant = $this->applicantRepository->findWithoutFail($id);

        if (empty($applicant)) {
            return $this->sendError(trans('message.unfound'));
        }
        $result = $applicant->toArray();
        $result['certificates'] = $applicant->certificates()->pluck('certificates.id')->toArray();
        return $this->sendResponse($result, trans('message.retrieve'));
    }

    /**
     * Update the specified Applicant in storage.
     * PUT/PATCH /applicants/{id}
     *
     * @param  int $id
     * @param UpdateApplicantAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApplicantAPIRequest $request)
    {
        $input = $request->all();

        /** @var Applicant $applicant */
        $applicant = $this->applicantRepository->findWithoutFail($id);

        if (empty($applicant)) {
            return $this->sendError(trans('message.unfound'));
        }

        $applicant = $this->applicantRepository->update($input, $id);

        return $this->sendResponse($applicant->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified Applicant from storage.
     * DELETE /applicants/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Applicant $applicant */
        $applicant = $this->applicantRepository->findWithoutFail($id);

        if (empty($applicant)) {
            return $this->sendError(trans('message.unfound'));
        }

        $applicant->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }
}
