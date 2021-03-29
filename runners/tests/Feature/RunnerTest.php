<?php

namespace Tests\Feature;

use App\Models\Runner;
use App\User;
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
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        factory(Runner::class)->make([
            'name'  => 'Teste 1',
            'cpf'   => '11111111111',
            'birthday' => '1985-03-15'
        ]);

        factory(Runner::class)->make([
            'name'  => 'Teste 2',
            'cpf'   => '22222222222',
            'birthday' => '1980-03-15'
        ]);

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/list.runner', [], $headers)
        ->assertStatus(200)->assertJsonStructure([
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
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        $payload = [
            'name'  => 'Teste Cadastro',
            'cpf'   => '22222222222',
            'birthday' => '1980-03-15'
        ];

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/add.runner', $payload, $headers)
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
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        $payload = [
            'name'  => 'Teste Cadastro',
            'cpf'   => '11111111111',
            'birthday' => '1980-03-15'
        ];

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/add.runner', $payload, $headers);
        $this->json('POST', '/api/add.runner', $payload, $headers)
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
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => '1234',
            'api_token' => '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'
        ]);

        $token = '0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT';
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name'  => '',
            'cpf'   => '11111111111',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'name'  => 'teste',
            'cpf'   => '',
            'birthday' => '1980-03-15'
        ];

        $this->json('POST', '/api/add.runner', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'name'  => 'teste',
            'cpf'   => '11111111111',
            'birthday' => ''
        ];

        $this->json('POST', '/api/add.runner', $payload, $headers)
            ->assertStatus(404);

        $payload = [
            'name'  => '',
            'cpf'   => '',
            'birthday' => ''
        ];

        $this->json('POST', '/api/add.runner', $payload, $headers)
            ->assertStatus(404);
    }
}
