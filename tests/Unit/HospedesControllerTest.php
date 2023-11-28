<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hospede; // Importe o modelo Hospede

class HospedesControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function quantidade_caracteres_cpf()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifique erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => [
                'cpf' => [
                    'O documento informado não é válido (CPF ou CNPJ).'
                ]
            ]
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function apenas_caracteres_numericos()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => 'a781004!52'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => [
                'cpf' => [
                    'O campo deve conter apenas números.',
                    'O documento informado não é válido (CPF ou CNPJ).'
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function cpf_valido_digito_verificador()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => [
                'cpf' => [
                    'O documento informado não é válido (CPF ou CNPJ).',
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function quantidade_caracteres_telefone()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => [
                'telefone' => [
                    'O telefone/celular deve conter o formato de 10 (telefone) ou 11 (celular) dígitos',
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function caracteres_numericos_telefone()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '+1196592446',
            'cpf' => '12345678901'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => [
                'telefone' => [
                    'O telefone/celular deve conter o formato de 10 (telefone) ou 11 (celular) dígitos',
                    'O campo deve conter apenas números.'
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function atributos_obrigatorios_nao_preenchidos()
    {
        $data = [
            'nome' => '',
            'email' => '',
            'telefone' => '',
            'cpf' => ''
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);   
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function  hospede_criado_com_sucesso()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hóspede (status HTTP 201 - Created)
        $response->assertStatus(201);   

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'message' => 'Hóspede cadastrado com sucesso!'
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function busca_hospede()
    {
        $data = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $data);

        // Verifica erro na crianção do hospeionário (status HTTP 201 - OK)
        $response->assertStatus(201);

        $hospedeId = hospede::latest()->first()->id;


        // Execute a solicitação de busca
        $response = $this->get("/api/hospedes/{$hospedeId}");

        // Verifique se a resposta é bem-sucedida (status HTTP 200 - OK)
        $response->assertStatus(200);

        // Verifique se o id do hóspede foi encontrado no banco
        $this->assertDatabaseHas('hospedes', [
            'id' => $hospedeId
        ]);

    }
}