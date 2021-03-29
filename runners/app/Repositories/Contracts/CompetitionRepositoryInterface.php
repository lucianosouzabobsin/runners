<?php

namespace App\Repositories\Contracts;

interface CompetitionRepositoryInterface
{
    public function make(array $data);
    public function getAll();
    public function existCompetition(array $data);
    public function getCompetitions();
    public function getCompetition($id);
    public function getRangeAges();
    public function getTypes();
}
