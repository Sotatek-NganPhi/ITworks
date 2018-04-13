<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLinkAPIRequest;
use App\Http\Requests\API\UpdateLinkAPIRequest;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;

/**
 * Class LinkController
 * @package App\Http\Controllers\API
 */

class LinkAPIController extends AppBaseController
{
    /** @var  LinkRepository */
    private $linkRepository;

    public function __construct(LinkRepository $linkRepo)
    {
        $this->linkRepository = $linkRepo;
    }

    /**
     * Display a listing of the Link.
     * GET|HEAD /links
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->linkRepository->pushCriteria(new BaseCriteria($request));
        $this->linkRepository->pushCriteria(new LimitOffsetCriteria($request));
        $links = $this->linkRepository->with(['regions'])->paginate($request->input('limit'));
        return $this->sendResponse($links->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Link in storage.
     * POST /links
     *
     * @param CreateLinkAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLinkAPIRequest $request)
    {
        $input = $request->all();

        $links = $this->linkRepository->create($input);

        return $this->sendResponse($links->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Link.
     * GET|HEAD /links/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Link $link */
        $link = $this->linkRepository->findWithoutFail($id);

        if (empty($link)) {
            return $this->sendError('Link not found');
        }

        $result = $link->toArray();

        $result['regions'] = $link->regions()->pluck('region_id');
        return $this->sendResponse($result, trans('message.retrieve'));
    }

    /**
     * Update the specified Link in storage.
     * PUT/PATCH /links/{id}
     *
     * @param  int $id
     * @param UpdateLinkAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLinkAPIRequest $request)
    {
        $input = $request->all();

        /** @var Link $link */
        $link = $this->linkRepository->findWithoutFail($id);

        if (empty($link)) {
            return $this->sendError(trans('message.unfound'));
        }

        $link = $this->linkRepository->update($input, $id);

        $result = $link->toArray();

        $result['regions'] = $link->regions()->pluck('region_id');

        return $this->sendResponse($result, trans('message.update'));
    }

    /**
     * Remove the specified Link from storage.
     * DELETE /links/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Link $link */
        $link = $this->linkRepository->findWithoutFail($id);

        if (empty($link)) {
            return $this->sendError(trans('message.unfound'));
        }

        $link->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }
}
