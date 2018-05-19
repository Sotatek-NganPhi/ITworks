<?php

use Faker\Factory as Faker;
use App\Models\CurrentSituation;
use App\Repositories\CurrentSituationRepository;

trait MakeCurrentSituationTrait
{
    /**
     * Create fake instance of CurrentSituation and save it in database
     *
     * @param array $currentSituationFields
     * @return CurrentSituation
     */
    public function makeCurrentSituation($currentSituationFields = [])
    {
        /** @var CurrentSituationRepository $currentSituationRepo */
        $currentSituationRepo = App::make(CurrentSituationRepository::class);
        $theme = $this->fakeCurrentSituationData($currentSituationFields);
        return $currentSituationRepo->create($theme);
    }

    /**
     * Get fake instance of CurrentSituation
     *
     * @param array $currentSituationFields
     * @return CurrentSituation
     */
    public function fakeCurrentSituation($currentSituationFields = [])
    {
        return new CurrentSituation($this->fakeCurrentSituationData($currentSituationFields));
    }

    /**
     * Get fake data of CurrentSituation
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCurrentSituationData($currentSituationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $currentSituationFields);
    }
}
