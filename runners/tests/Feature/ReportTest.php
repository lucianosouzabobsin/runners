<?php

namespace Tests\Feature;

use App\Competition;
use App\Runner;
use App\RunnerCompetition;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * Test Runners are listed correctly.
     *
     * @return void
     */
    public function testRunnersAreListedCorrectly()
    {
        factory(Runner::class)->create([
            'name'  => 'Teste 3',
            'cpf'   => '11111111113',
            'birthday' => '2001-03-15'
        ]);

        factory(Competition::class)->create([
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ]);

        factory(RunnerCompetition::class)->create([
            'runner_id'  => '1',
            'competition_id' => '1',
            'hour_end' => '09:00:01'
        ]);

        factory(RunnerCompetition::class)->create([
            'runner_id'  => '2',
            'competition_id' => '1',
            'hour_end' => '09:00:00'
        ]);

        factory(RunnerCompetition::class)->create([
            'runner_id'  => '1',
            'competition_id' => '1',
            'hour_end' => '09:00:03'
        ]);


        $response = $this->json('POST', '/api/report.get.list', [])
        ->assertStatus(200)
        ->assertJsonStructure([
                '*' => [
                        'competition_id',
                        'type',
                        'runner_id',
                        'min_age',
                        'max_age',
                        'name',
                        'runner_age',
                        'trial_time',
                        'position_competition',
                        'position_range_age',
                        'position_range_age_type'
                    ],
            ]);
    }
}
