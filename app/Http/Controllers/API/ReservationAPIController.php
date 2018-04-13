<?php

namespace App\Http\Controllers\API;

use App\Consts;
use App\Http\Requests\API\CreateReservationAPIRequest;
use App\Http\Requests\API\UpdateReservationAPIRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Repositories\Criteria\BaseCriteria;
use Response;

/**
 * Class ReservationController
 * @package App\Http\Controllers\API
 */

class ReservationAPIController extends AppBaseController
{
    /** @var  ReservationRepository */
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepo)
    {
        $this->reservationRepository = $reservationRepo;
    }

    /**
     * Display a listing of the Reservation.
     * GET|HEAD /reservations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->reservationRepository->pushCriteria(new BaseCriteria($request));
        $this->reservationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $reservations = $this->reservationRepository->with(['currentSituation'])->paginate(Consts::PAGE_SIZE);
        $result = $reservations->toArray();
        foreach ($result['data'] as $key => $reservation) {
            $current_situations = is_array($reservation['current_situation']) ? $reservation['current_situation']['name'] : null;
            $result['data'][$key]['current_situations'] = $current_situations;
        }
        return $this->sendResponse($result, trans('message.retrieve'));
    }

    /**
     * Store a newly created Reservation in storage.
     * POST /reservations
     *
     * @param CreateReservationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateReservationAPIRequest $request)
    {
        $input = $request->all();

        $reservations = $this->reservationRepository->create($input);

        return $this->sendResponse($reservations->toArray(), trans('message.save'));
    }

    /**
     * Display the specified Reservation.
     * GET|HEAD /reservations/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->findWithoutFail($id);

        if (empty($reservation)) {
            return $this->sendError(trans('message.unfound'));
        }

        return $this->sendResponse($reservation->toArray(), trans('message.retrieve'));
    }

    /**
     * Update the specified Reservation in storage.
     * PUT/PATCH /reservations/{id}
     *
     * @param  int $id
     * @param UpdateReservationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReservationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->findWithoutFail($id);

        if (empty($reservation)) {
            return $this->sendError( trans('message.unfound'));
        }

        $reservation = $this->reservationRepository->update($input, $id);

        return $this->sendResponse($reservation->toArray(),  trans('message.retrieve'));
    }

    /**
     * Remove the specified Reservation from storage.
     * DELETE /reservations/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->findWithoutFail($id);

        if (empty($reservation)) {
            return $this->sendError(trans('message.unfound'));
        }

        $reservation->delete();

        return $this->sendResponse($id, trans('message.deletable'));
    }
}
