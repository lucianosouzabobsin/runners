<?php

namespace Tests\Feature;

use App\Runner;
use Tests\TestCase;

class RunnerTest extends TestCase
{
    /**
     * Test Runners are listed correctly.
     *
     * @return void
     */
    public function testRunnersAreListedCorrectly()
    {
        factory(Runner::class)->create([
            'name'  => 'Teste 1',
            'cpf'   => '11111111111',
            'birthday' => '1985-03-15'
        ]);

        factory(Runner::class)->create([
            'name'  => 'Teste 2',
            'cpf'   => '22222222222',
            'birthday' => '1980-03-15'
        ]);

        $response = $this->json('GET', '/api/list.runner', [])
        ->assertStatus(200)
        ->assertJson([
                [ 'name' => 'Teste 1', 'cpf' => '11111111111', 'birthday' => '1985-03-15' ],
                [ 'name' => 'Teste 2', 'cpf' => '22222222222', 'birthday' => '1980-03-15' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'cpf', 'birthday'],
            ]);
    }

    /**
     * Test Runner save correctly.
     *
     * @return void
     */
    public function testsRunnerCreatedCorrectly()
    {
        $payload = [
            'name'  => 'Teste Cadastro',
            'cpf'   => '22222222222',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(201)
            ->assertJson([
                'name' => 'Teste Cadastro',
                'cpf' => '22222222222',
                'birthday' => '1980-03-15'
                ]
            );
    }

    /**
     * Test Runner save with duplicate cpf.
     *
     * @return void
     */
    public function testsRunnerCreatedCpfIncorrectly()
    {
        factory(Runner::class)->create([
            'name'  => 'Teste 1',
            'cpf'   => '11111111111',
            'birthday' => '1985-03-15'
        ]);

        $payload = [
            'name'  => 'Teste Cadastro',
            'cpf'   => '11111111111',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(404)
            ->assertJson(['error' => 'The cpf already registered.']);
    }

    /**
     * Test Runner save with emptys.
     *
     * @return void
     */
    public function testsRunnerCreatedFieldsEmptyIncorrectly()
    {
        $payload = [
            'name'  => '',
            'cpf'   => '11111111111',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(404);

        $payload = [
            'name'  => 'teste',
            'cpf'   => '',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(404);

        $payload = [
            'name'  => 'teste',
            'cpf'   => '11111111111',
            'birthday' => ''
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(404);

        $payload = [
            'name'  => '',
            'cpf'   => '',
            'birthday' => ''
        ];

        $this->json('POST', '/api/add.runner', $payload)
            ->assertStatus(404);
    }
}
