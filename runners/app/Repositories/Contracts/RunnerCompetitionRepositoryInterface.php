<?php

namespace App\Repositories\Contracts;

interface RunnerCompetitionRepositoryInterface
{
    public function make(array $data);
    public function canRunOnDate(int $runner_id, string $date);
    public function getByAgeTypeTrial();
    public function report(array $inputs);
    public function findOrFail($id);
}
