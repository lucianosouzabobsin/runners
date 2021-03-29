<?php

namespace App\Repositories;

use App\Repositories\Contracts\RunnerRepositoryInterface;
use App\Models\Runner;

class RunnerRepository implements RunnerRepositoryInterface
{
    protected $entity;

    public function __construct(Runner $runner)
    {
        $this->entity = $runner;
    }

    /**
     * Get Runer with age
     *
     * @return array
     */
    public function getWithAge($id)
    {
        $runner = $this->entity->select('*')->
        selectRaw("TIMESTAMPDIFF (YEAR, birthday,CURDATE()) as age")
        ->where('id', $id)
        ->get()
        ->toArray();

        if(!empty($runner)){
            return $runner[0];
        }

        return $runner;
    }

    /**
     * Create runner
     *
     * @return array
     */
    public function make(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Return runners
     *
     * @return array
     */
    public function getAll()
    {
        return $this->entity->all();
    }
}
