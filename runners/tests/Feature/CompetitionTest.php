<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\User;
use Tests\TestCase;

class CompetitionTest extends TestCase
{
    /**
     * Test Competitions are listed correctly.
     *
     * @return void
     */
    public function testCompetitionsAreListedCorrectly()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        factory(Competition::class)->create([
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ]);

        factory(Competition::class)->create([
            'type' => '3',
            'date' =>  '2021-01-16',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ]);


        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];
        $response = $this->json('GET', '/api/list.competition', [], $headers)
        ->assertJson([
                [
                    'id' => 1,
                    'type' => '3',
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => '18',
                    'max_age' => '25'
                ],
                [
                    'id' => 2,
                    'type' => '3',
                    'date' => '2021-01-16',
                    'hour_init' => '08:00:00',
                    'min_age' => '18',
                    'max_age' => '25'
                ],
            ])
            ->assertJsonStructure([
                '*' => ['id', 'type', 'date', 'hour_init','min_age','max_age'],
            ]);
    }

    /**
     * Test Runner save with duplicate cpf.
     *
     * @return void
     */
    public function testsCompetitionCreatedDuplicityIncorrectly()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        factory(Competition::class)->make([
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ]);

        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);
    }

    /**
     * Test Competition save with emptys.
     *
     * @return void
     */
    public function testsCompetitionCreatedFieldsEmptyIncorrectly()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'type' => '',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);


        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => ''
        ];

        $this->json('POST', '/api/add.competition', $payload, $headers)
            ->assertStatus(404);
    }
}
