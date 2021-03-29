<?php

namespace App\Services;

use App\Repositories\Contracts\CompetitionRepositoryInterface;
use Carbon\Carbon;

class ServiceCompetition
{
    protected $competitionRepository;

    public function __construct(CompetitionRepositoryInterface $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * Create competition
     *
     * @return array
    */
    public function make(array $data)
    {
        return $this->competitionRepository->make($data);
    }

    /**
     * Get all competitions
     *
     * @return array
    */
    public function getAll()
    {
        return $this->competitionRepository->getAll();
    }

    /**
     * Return if exists competition
     *
     * @return array
    */
    public function existCompetition(array $data)
    {
        return $this->competitionRepository->existCompetition($data);
    }

    /**
     * Return ids competitions
     *
     * @return array
    */
    public function getCompetitions()
    {
        return $this->competitionRepository->getCompetitions();
    }

    /**
     * Return ids competition
     *
     * @return array
    */
    public function getCompetition($id)
    {
        return $this->competitionRepository->getCompetition($id);
    }

    /**
     * Return range ages
     *
     * @return array
    */
    public function getRangeAges()
    {
        return $this->competitionRepository->getRangeAges();
    }

    /**
     * Return types competitions
     *
     * @return array
    */
    public function getTypes()
    {
        return $this->competitionRepository->getTypes();
    }

    /**
     * Return time trial in competition
     *
     * @return array
    */
    public function getTimeCompetition(int $id, string $hour_end)
    {
        $competition = $this->competitionRepository->getCompetition($id);

        $init = Carbon::createFromFormat('H:i:s', $competition[0]['hour_init']);
        $end = Carbon::createFromFormat('H:i:s', $hour_end);

        return $init->diff($end)->format('%H:%I:%S');
    }
}
