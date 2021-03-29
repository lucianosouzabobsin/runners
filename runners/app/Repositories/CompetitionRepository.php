<?php

namespace App\Repositories;

use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Models\Competition;


class CompetitionRepository implements CompetitionRepositoryInterface
{
    protected $entity;

    public function __construct(Competition $competition)
    {
        $this->entity = $competition;
    }

    /**
     * Return competition
     *
     * @return array
     */
    public function getCompetition($id)
    {
        return $this->entity->where(['id' => $id])->get()->toArray();
    }

    /**
     * Verifiy exists competition
     *
     * @return array
     */
    public function existCompetition(array $data)
    {
        $existsCompetition = $this->entity->where($data)->get()->toArray();

        if(empty($existsCompetition)){
            return false;
        }

        return true;
    }

    /**
     * Return id competitions
     *
     * @return array
     */
    public function getCompetitions()
    {
        return $this->entity->select('id')->get()->toArray();
    }

    /**
     * Return ranges min max
     *
     * @return array
     */
    public function getRangeAges()
    {
        return $this->entity->select('min_age', 'max_age')->distinct()->get()->toArray();
    }

    /**
     * Return types
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->entity->select('type')->distinct()->get()->toArray();
    }

    /**
     * Create competition
     *
     * @return array
     */
    public function make(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Return competitions
     *
     * @return array
     */
    public function getAll()
    {
        return $this->entity->all();
    }
}
