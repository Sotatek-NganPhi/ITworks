<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateVideoAPIRequest;
use App\Http\Requests\API\UpdateVideoAPIRequest;
use App\Models\Video;
use App\Repositories\Criteria\BaseCriteria;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;
use App\Models\Region;

/**
 * Class VideoController
 * @package App\Http\Controllers\API
 */

class VideoAPIController extends AppBaseController
{
    /** @var  VideoRepository */
    private $videoRepository;

    public function __construct(VideoRepository $videoRepo)
    {
        $this->videoRepository = $videoRepo;
    }

    /**
     * Display a listing of the Video.
     * GET|HEAD /videos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->videoRepository->pushCriteria(new BaseCriteria($request));
        $this->videoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $videos = $this->videoRepository->paginate(15);

        return $this->sendResponse($videos->toArray(), 'Videos retrieved successfully');
    }

    /**
     * Store a newly created Video in storage.
     * POST /videos
     *
     * @param CreateVideoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVideoAPIRequest $request)
    {
        $input = $request->all();

        $videos = $this->videoRepository->create($input);

        return $this->sendResponse($videos->toArray(), 'Video saved successfully');
    }

    /**
     * Display the specified Video.
     * GET|HEAD /videos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        /** @var Video $video */
        $this->videoRepository->pushCriteria(new BaseCriteria($request));
        $video = $this->videoRepository->findWithoutFail($id);

        if (empty($video)) {
            return $this->sendError('Video not found');
        }

        return $this->sendResponse($video->toArray(), 'Video retrieved successfully');
    }

    /**
     * Update the specified Video in storage.
     * PUT/PATCH /videos/{id}
     *
     * @param  int $id
     * @param UpdateVideoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVideoAPIRequest $request)
    {
        $input = $request->all();

        /** @var Video $video */
        $video = $this->videoRepository->findWithoutFail($id);

        if (empty($video)) {
            return $this->sendError('Video not found');
        }

        $video = $this->videoRepository->update($input, $id);

        return $this->sendResponse($video->toArray(), 'Video updated successfully');
    }

    /**
     * Remove the specified Video from storage.
     * DELETE /videos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Video $video */
        $video = $this->videoRepository->findWithoutFail($id);

        if (empty($video)) {
            return $this->sendError('Video not found');
        }

        $video->delete();

        return $this->sendResponse($id, 'Video deleted successfully');
    }

    public function showVideoList($regionName)
    {
        $region = Region::findWhere('key', $regionName)->first();
        $videos = Video::select('videos.*')
            ->join('region_video', 'region_video.video_id', '=', 'videos.id')
            ->where('region_video.region_id', $region->id)
            ->where('videos.is_active', Consts::TRUE)
            ->distinct()
            ->orderBy('videos.id', 'asc')
            ->paginate(10);
        return view('app.video_list', [
            'regions' => Region::getAll(),
            'region' => (array) $region,
            'videos' => $videos,
        ]);

    }

    public function showVideoDetail($regionName, $id)
    {
        $region = Region::findWhere('key', $regionName)->first();
        $video = Video::where('id', $id)->first();
        if (is_null($video)) {
            abort(404);
        }
        return view('app.video_detail', [
            'region' => (array) $region,
            'regions' => Region::getAll(),
            'video' => $video,
        ]);
    }
}
