<?php

namespace App\Repositories\Contracts;

interface RunnerRepositoryInterface
{
    public function make(array $data);
    public function getAll();
    public function getWithAge($id);
}