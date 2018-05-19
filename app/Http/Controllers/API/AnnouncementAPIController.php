<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnnouncementAPIRequest;
use App\Http\Requests\API\UpdateAnnouncementAPIRequest;
use App\Models\Announcement;
use App\Repositories\AnnouncementRepository;
use App\Utils;
use App\Consts;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;

/**
 * Class AnnouncementController
 * @package App\Http\Controllers\API
 */

class AnnouncementAPIController extends AppBaseController
{
    /** @var  AnnouncementRepository */
    private $announcementRepository;

    public function __construct(AnnouncementRepository $announcementRepo)
    {
        $this->announcementRepository = $announcementRepo;
    }

    /**
     * Display a listing of the Announcement.
     * GET|HEAD /announcements
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->announcementRepository->pushCriteria(new BaseCriteria($request));
        $this->announcementRepository->pushCriteria(new LimitOffsetCriteria($request));
        $announcements = $this->announcementRepository->paginate();

        return $this->sendResponse($announcements->toArray(), trans('message.retrieve'));
    }

    /**
     * Store a newly created Announcement in storage.
     * POST /announcements
     *
     * @param CreateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnnouncementAPIRequest $request)
    {
        $input = $request->all();

        $announcements = $this->announcementRepository->create($input);

        return $this->sendResponse($announcements->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Announcement.
     * GET|HEAD /announcements/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->findWithoutFail($id);

        if (empty($announcement)) {
            return $this->sendError(trans('message.unfound'));
        }

        $result = $announcement->toArray();
        $result['regions'] = $announcement->regions()->get();
        return $this->sendResponse($result, trans('message.unfound'));
    }

    /**
     * Update the specified Announcement in storage.
     * PUT/PATCH /announcements/{id}
     *
     * @param  int $id
     * @param UpdateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnnouncementAPIRequest $request)
    {
        $input = $request->all();

        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->findWithoutFail($id);

        if (empty($announcement)) {
            return $this->sendError(trans('message.unfound'));
        }

        $announcement = $this->announcementRepository->update($input, $id);

        return $this->sendResponse($announcement->toArray(), trans('message.update'));
    }

    /**
     * Remove the specified Announcement from storage.
     * DELETE /announcements/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->findWithoutFail($id);

        if (empty($announcement)) {
            return $this->sendError(trans('message.unfound'));
        }

        $announcement->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }

    public function downloadCsv(Request $request)
    {
        $this->announcementRepository->pushCriteria(new BaseCriteria($request));
        $this->announcementRepository->pushCriteria(new LimitOffsetCriteria($request));
        $announcements = $this->announcementRepository->all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $headers = \Schema::getColumnListing('announcements');
        $csv->insertOne(Utils::utf8ToSjis($headers));

        foreach ($announcements as $announcement) {
            $csv->insertOne(Utils::utf8ToSjis($announcement->toArray()));
        }

        $csv->output('announcement.csv');
    }
}
