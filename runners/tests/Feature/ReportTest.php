<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\Runner;
use App\Models\RunnerCompetition;
use App\User;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * Test Runners are listed correctly.
     *
     * @return void
     */
    public function testRunnersResultsAreListedCorrectly()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

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


        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/report.get.list', [], $headers)
        ->assertStatus(200);
    }
}
