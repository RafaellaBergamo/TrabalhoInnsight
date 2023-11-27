<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Funcionario; // Importe o modelo Funcionario

class FuncionariosControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function quantidade_caracteres_cpf()
    {
        $data = [
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifique erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => [
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
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => 'a781004!52'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => [
                'cpf' => [
                    'O campo deve conter apenas números.',
                    'O documento informado não é válido (CPF ou CNPJ).'
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function funcionario_duplicado()
    {
        $data = [
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica se o funcionário foi criado corretamente (status HTTP 201 - Created)
        $response->assertStatus(201);
        
        $data = [
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => [
                'cpf' => [
                    'O documento informado não é válido (CPF ou CNPJ).',
                    'O CPF informado já está em uso.'
                ]
            ]
        ]); 
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function cpf_valido_digito_verificador()
    {
        $data = [
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '12345678901'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => [
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
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '119659246',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => [
                'telefone' => [
                    'O telefone/celular deve conter o formato de 10 (telefone) ou 11 (celular) dígitos',
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
            'senha' => '',
            'tipo' => '',
            'cpf' => ''
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);   
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function  funcionado_criado_com_sucesso()
    {
        $data = [
            'nome' => 'Nome Funcionario',
            'email' => 'func@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 1,
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $data);

        // Verifica erro na crianção do funcionário (status HTTP 201 - Created)
        $response->assertStatus(201);   

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'message' => 'Funcionário cadastrado com sucesso!'
        ]); 
    }
}