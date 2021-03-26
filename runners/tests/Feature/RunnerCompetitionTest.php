<?php

namespace Tests\Feature;

use App\Competition;
use App\Runner;
use Tests\TestCase;

class RunnerCompetitionTest extends TestCase
{
    /**
     * Test RunnersCompetition save incorrectly.
     *
     * @return void
     */
    public function testsRunnerCompetitionCreatedIncorrectly()
    {
        factory(Runner::class)->create([
            'name'  => 'Teste 1',
            'cpf'   => '11111111111',
            'birthday' => '2000-03-15'
        ]);

        factory(Competition::class)->create([
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ]);

        $payload = [
            'runner_id'  => '1',
            'competition_id' => '1',
            'hour_end' => '09:00:00'
        ];

        $this->json('POST', '/api/add.runner.competition', $payload)
            ->assertStatus(404);
    }
}
