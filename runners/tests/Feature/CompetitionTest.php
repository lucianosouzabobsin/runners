<?php

namespace Tests\Feature;

use App\Competition;
use Tests\TestCase;

class CompetitionTest extends TestCase
{
    /**
     * Test Runners are listed correctly.
     *
     * @return void
     */
    public function testCompetitionsAreListedCorrectly()
    {
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

        $response = $this->json('GET', '/api/list.competition', [])
        ->assertStatus(200)
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
     * Test Runner save correctly.
     *
     * @return void
     */
    public function testsCompetitionCreatedCorrectly()
    {
        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(201)
            ->assertJson([
                'type' => '3',
                'date' =>  '2021-01-15',
                'hour_init' => '08:00:00',
                'min_age' => '18',
                'max_age' => '25'
                ]
            );
    }

    /**
     * Test Runner save with duplicate cpf.
     *
     * @return void
     */
    public function testsCompetitionCreatedDuplicityIncorrectly()
    {
        factory(Competition::class)->create([
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

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);
    }

    /**
     * Test Competition save with emptys.
     *
     * @return void
     */
    public function testsCompetitionCreatedFieldsEmptyIncorrectly()
    {
        $payload = [
            'type' => '',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '',
            'min_age' => '18',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);

        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '',
            'max_age' => '25'
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);


        $payload = [
            'type' => '3',
            'date' =>  '2021-01-15',
            'hour_init' => '08:00:00',
            'min_age' => '18',
            'max_age' => ''
        ];

        $this->json('POST', '/api/add.competition', $payload)
            ->assertStatus(404);
    }

}
