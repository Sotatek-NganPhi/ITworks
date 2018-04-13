<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInterviewAPIRequest;
use App\Http\Requests\API\UpdateInterviewAPIRequest;
use App\Models\Interview;
use App\Models\CategoryInterview;
use App\Repositories\InterviewRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;

/**
 * Class InterviewController
 * @package App\Http\Controllers\API
 */

class InterviewAPIController extends AppBaseController
{
    /** @var  InterviewRepository */
    private $interviewRepository;

    public function __construct(InterviewRepository $interviewRepo)
    {
        $this->interviewRepository = $interviewRepo;
    }

    /**
     * Display a listing of the Interview.
     * GET|HEAD /interviews
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->interviewRepository->pushCriteria(new BaseCriteria($request));
        $this->interviewRepository->pushCriteria(new LimitOffsetCriteria($request));
        $interviews = $this->interviewRepository->with(['regions'])->paginate($request->input('limit'));

        return $this->sendResponse($interviews->toArray(), 'Interviews retrieved successfully');
    }

    /**
     * Store a newly created Interview in storage.
     * POST /interviews
     *
     * @param CreateInterviewAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateInterviewAPIRequest $request)
    {
        $input = $request->all();

        $interviews = $this->interviewRepository->create($input);

        return $this->sendResponse($interviews->toArray(), 'Interview saved successfully');
    }

    /**
     * Display the specified Interview.
     * GET|HEAD /interviews/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Interview $interview */
        $interview = $this->interviewRepository->findWithoutFail($id);

        if (empty($interview)) {
            return $this->sendError('Interview not found');
        }
        $result = $interview->toArray();

        $result['regions'] = $interview->regions()->pluck('region_id');

        return $this->sendResponse($result, 'Interview retrieved successfully');
    }

    /**
     * Update the specified Interview in storage.
     * PUT/PATCH /interviews/{id}
     *
     * @param  int $id
     * @param UpdateInterviewAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInterviewAPIRequest $request)
    {
        $input = $request->all();

        /** @var Interview $interview */
        $interview = $this->interviewRepository->findWithoutFail($id);

        if (empty($interview)) {
            return $this->sendError('Interview not found');
        }

        $interview = $this->interviewRepository->update($input, $id);

        $result = $interview->toArray();

        $result['regions'] = $interview->regions()->pluck('region_id');

        return $this->sendResponse($result, 'Interview updated successfully');
    }

    /**
     * Remove the specified Interview from storage.
     * DELETE /interviews/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Interview $interview */
        $interview = $this->interviewRepository->findWithoutFail($id);

        if (empty($interview)) {
            return $this->sendError('Interview not found');
        }

        $interview->delete();

        return $this->sendResponse($id, 'Interview deleted successfully');
    }

    public function getCategories()
    {
        $cat = CategoryInterview::all();
        return $this->sendResponse($cat->toArray(), 'Category Interviews retrieved successfully');
    }
}
