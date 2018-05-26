<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\MailRequest;
use App\Models\Draft;
use App\Models\UserReferences;
use App\User;
use DB;
use Response;
use Validator;

use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

use App\Consts;
use App\Models\Candidate;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCandidateAPIRequest;
use App\Http\Requests\API\UpdateCandidateAPIRequest;
use App\Repositories\CandidateRepository;
use App\Repositories\Criteria\BaseCriteria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use View;
use Carbon\Carbon;

/**
 * Class CandidateController
 * @package App\Http\Controllers\API
 */

class CandidateAPIController extends AppBaseController
{
    /** @var  CandidateRepository */
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }

    /**
     * Display a listing of the Candidate.
     * GET|HEAD /candidates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->candidateRepository->with(['user'])->joinUsers()->pushCriteria(new BaseCriteria($request));
        $this->candidateRepository->pushCriteria(new LimitOffsetCriteria($request));
        $candidates = $this->candidateRepository->paginate($request->input('limit'), ['candidates.id', 'users.name', 'users.birthday', 'users.email', 'candidates.created_at']);

        return $this->sendResponse($candidates->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Candidate in storage.
     * POST /candidates
     *
     * @param CreateCandidateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCandidateAPIRequest $request)
    {
        $input = $request->all();

        $candidates = $this->candidateRepository->create($input);

        return $this->sendResponse($candidates->toArray(), trans('message.save'));
    }

    protected function getRelationIds($candidate, $relation)
    {
        return DB::table("candidate_{$relation}")
            ->join('candidates', "candidate_{$relation}.candidate_id", '=', 'candidates.id')
            ->select("candidate_{$relation}.{$relation}_id")
            ->where('candidates.id', $candidate->id)
            ->pluck("{$relation}_id");
    }

    /**
     * Display the specified Candidate.
     * GET|HEAD /candidates/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->with(['user'])->findWithoutFail($id);

        if (empty($candidate)) {
            return $this->sendError(trans('message.unfound'));
        }

        $result = $candidate->toArray();

        $result['prefectures'] = $this->getRelationIds($candidate, 'prefecture');
        $result['certificates'] = $this->getRelationIds($candidate, 'certificate');
        $result['certificateGroups'] = $this->getRelationIds($candidate, 'certificate');
        return $this->sendResponse($result, trans('message.retrieve'));
    }

    public function validateUserUniqueAttributes($request, $candidate)
    {
        $rules = array();
        $input = $request->get('user', []);
        if ($candidate->user->email !== $input['email']) {
            $rules['email'] = 'unique:users';
        }

        if (!empty($rules)) {
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return collect($validator->errors()->toArray())->mapWithKeys(function($messages, $key) {
                    return ["user.{$key}" => $messages];
                });
            }
        }
    }

    /**
     * Update the specified Candidate in storage.
     * PUT/PATCH /candidates/{id}
     *
     * @param  int $id
     * @param UpdateCandidateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCandidateAPIRequest $request)
    {
        $input = $request->all();

        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->findWithoutFail($id);

        if (empty($candidate)) {
            return $this->sendError(trans('message.unfound'));
        }

        $messages = $this->validateUserUniqueAttributes($request, $candidate);
        if ($messages) {
            return Response::json(ResponseUtil::makeError($messages), 400);
        }
        $user = $input['user'];
        unset($input['user']);
        User::where('id', $user['id'])->update($user);
        Draft::where('user_id', $user['id'])->delete();
        $candidate = $this->candidateRepository->update($input, $id);
        $candidate->user->update($request->get('user', []));

        return $this->sendResponse($candidate->toArray(), trans('message.update'));
    }

    public function updateResumeInfo($id, Request $request)
    {
        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->findWithoutFail($id);

        if (empty($candidate)) {
            return $this->sendError(trans('message.unfound'));
        }

        $input = $request->all();
        $candidate->update($input);
        $candidate->user->update($request->get('user', []));
        return $this->sendResponse($candidate->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified Candidate from storage.
     * DELETE /candidates/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    // Don't allow to delete candidate via api
    public function destroy($id)
    {
        return $this->sendError(trans('message.not_allow'), 400);
    }

    public function sendMail(MailRequest $request)
    {
        Mail::to(['email' => $request['email']])
            ->queue(new \App\Mail\Candidate($request->all()));
        return $this->sendResponse(null, trans('message.send_mail'));
    }

    public function sendMailToCompany(MailRequest $request)
    {
        Mail::to(['email' => $request['email']])
            ->queue(new \App\Mail\SendMailToCompany($request->all()));
        return $this->sendResponse(null, trans('message.send_mail'));
    }

    public function removeReferralCode($id)
    {
        $candidate = $this->candidateRepository->find($id);
        $record = UserReferences::where('user_id', $candidate->user_id)->first();
        $record->referral_code = null;
        $record->save();
        return $this->sendResponse($id, trans('message.deletable'));
    }
}
