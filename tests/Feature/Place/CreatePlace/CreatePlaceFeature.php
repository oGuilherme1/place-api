<?php

namespace Tests\Feature\Place\CreatePlace;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePlaceFeature extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testItCreatesAPlaceSuccessfully()
    {
        // Simula os dados de entrada como você faria no Insomnia
        $placeData = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State'
        ];

        // Faz a requisição POST à API
        $response = $this->postJson('/api/place', $placeData);

        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'message' => 'Place created successfully',
                     ],
                 ]);

        // Verifica se os dados foram salvos no banco de dados
        $this->assertDatabaseHas('places', [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State'
        ]);
    }

    /** @test */
    public function testItFailsToCreateAPlaceWithMissingFields()
    {
        // Dados inválidos (faltando o campo 'name')
        $placeData = [
            'city' => 'Test City',
            'state' => 'Test State'
        ];

        // Faz a requisição POST à API
        $response = $this->postJson('/api/place', $placeData);

        // Verifica se houve erro de validação
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function testItFailsToCreateAPlaceIfAlreadyExists()
    {
        // Dados válidos
        $placeData = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State'
        ];

        // Faz a primeira requisição POST à API
        $this->postJson('/api/place', $placeData);

        // Faz a segunda requisição POST com os mesmos dados
        $response = $this->postJson('/api/place', $placeData);

        // Verifica se houve erro de duplicação
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'This place is already registered',
                 ]);
    }
}
