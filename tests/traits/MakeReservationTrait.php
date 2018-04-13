<?php

use Faker\Factory as Faker;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;

trait MakeReservationTrait
{
    /**
     * Create fake instance of Reservation and save it in database
     *
     * @param array $reservationFields
     * @return Reservation
     */
    public function makeReservation($reservationFields = [])
    {
        /** @var ReservationRepository $reservationRepo */
        $reservationRepo = App::make(ReservationRepository::class);
        $theme = $this->fakeReservationData($reservationFields);
        return $reservationRepo->create($theme);
    }

    /**
     * Get fake instance of Reservation
     *
     * @param array $reservationFields
     * @return Reservation
     */
    public function fakeReservation($reservationFields = [])
    {
        return new Reservation($this->fakeReservationData($reservationFields));
    }

    /**
     * Get fake data of Reservation
     *
     * @param array $postFields
     * @return array
     */
    public function fakeReservationData($reservationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'expo_id' => $fake->randomDigitNotNull,
            'surname' => $fake->word,
            'name' => $fake->word,
            'surname_phonetic' => $fake->word,
            'name_phonetic' => $fake->word,
            'gender' => $fake->randomDigitNotNull,
            'email' => $fake->word,
            'current_situation_id' => $fake->randomDigitNotNull,
            'phone_number' => $fake->word,
            'agreed_to_policy' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'full_name' => $fake->word,
            'full_name_phonetic' => $fake->word
        ], $reservationFields);
    }
}
