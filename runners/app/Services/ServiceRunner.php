<?php

namespace App\Services;

use App\Repositories\Contracts\RunnerRepositoryInterface;

class ServiceRunner
{
    protected $runnerRepository;

    public function __construct(RunnerRepositoryInterface $runnerRepository)
    {
        $this->runnerRepository = $runnerRepository;
    }

    /**
     * Create runner
     *
     * @return array
    */
    public function make(array $data)
    {
        return $this->runnerRepository->make($data);
    }

    /**
     * get all runners
     *
     * @return array
    */
    public function getAll()
    {
        return $this->runnerRepository->getAll();
    }

    /**
     * Return runner with age
     *
     * @return array
    */
    public function getWithAge($id)
    {
        return $this->runnerRepository->getWithAge($id);
    }

    /**
     * Return runner age
     *
     * @return integer
    */
    public function getRunnerAge($id)
    {
        $runner = $this->runnerRepository->getWithAge($id);
        return $runner['age'];
    }
}
