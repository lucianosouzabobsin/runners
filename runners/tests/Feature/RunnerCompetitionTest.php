<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\Runner;
use App\User;
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
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        factory(Runner::class)->make([
            'name'  => 'Teste 1',
            'cpf'   => '11111111111',
            'birthday' => '2000-03-15'
        ]);

        factory(Competition::class)->make([
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

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/add.runner.competition', $payload, $headers)
            ->assertStatus(404);
    }
}
