<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hotel; // Importe o modelo Hotel

class HoteisControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function apenas_funcionario_master_pode_cadastrar_hotel()
    {
        // funcionário existe na base mas não é um usuário Master
        $data = [
            'emailFuncionario' => 'funcionario@example.com',
            'senhaFuncionario'=> 'senha123',
            'cnpj'=> '28324061000123',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hoteis', $data);

        // Verifique erro na crianção do hóspede (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => 'Funcionário sem acesso.'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function quantidade_caracteres_cnpj()
    {
        // funcionário é um usuário Master
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 2,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);

        $data = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario'=> '123456',
            'cnpj'=> '28324061',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hotel
        $response = $this->post('/api/hoteis', $data);

        // Verifique erro na crianção do hóspede (status HTTP 422 - Created)
        $response->assertStatus(422);

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'error' => [
                'cnpj' => [
                    'O documento informado não é válido (CPF ou CNPJ).'
                ]
            ]
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function atributos_obrigatorios_nao_preenchidos()
    {
        $data = [
            'emailFuncionario' => 'funcionario@example.com',
            'senhaFuncionario'=> 'senha123',
            'cnpj'=> '',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/hoteis', $data);

        // Verifica erro na crianção do funcionário (status HTTP 422 - Bad Request)
        $response->assertStatus(422);   
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function endereco_invalido()
    {
        // funcionário é um usuário Master
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 2,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);

        $data = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario'=> '123456',
            'cnpj'=> '28324061000123',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hotel
        $response = $this->post('/api/hoteis', $data);

        // Verifique erro na crianção do hóspede (status HTTP 422 - Created)
        $response->assertStatus(422);

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'error' => [
                "endereco" => [
                    'O endereço deve conter a rua, o número e o cep.'
                ]
            ]
        ]);
    }
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function sucesso_em_cadastrar_hotel()
    {
        // funcionário é um usuário Master
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 2,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);

        $data = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario'=> '123456',
            'cnpj'=> '28324061000123',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hotel
        $response = $this->post('/api/hoteis', $data);

        // Verifique erro na crianção do hotel (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'message' => 'Hotel cadastrado com sucesso!'
        ]);
    }

    /*use RefreshDatabase; // Utiliza transações e rollback
    /** @test 
    public function atualiza_hotel()
    {
        // funcionário é um usuário Master
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 2,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);

        $data = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario'=> '123456',
            'cnpj'=> '28324061000123',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hotel
        $response = $this->post('/api/hoteis', $data);

        // Verifica erro na crianção do hotel (status HTTP 201 - OK)
        $response->assertStatus(201);

        $hotelId = hotel::latest()->first()->id;

        $dadosAtualizados = [
            'qtdQuartos' => 80,
        ];

        // Execute a solicitação de atualização
        $response = $this->put("/api/hoteis", $dadosAtualizados);

        // Verifique se a resposta é bem-sucedida (status HTTP 200 OK)
       // $response->assertStatus(200);

        // Verifique se o banco de dados foi atualizado corretamente
        $this->assertDatabaseHas('hotels', [
            'id' => $hotelId,
            'qtdQuartos' => 80,
        ]);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'message' => 'Hotel atualizado com sucesso!'
        ]); 
    }*/

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function busca_hotel()
    {
        // funcionário é um usuário Master
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 2,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);

        $data = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario'=> '123456',
            'cnpj'=> '28324061000123',
            'razaoSocial'=> 'Hotel Exemplo',
            'qtdQuartos'=> 50,
            'telefone'=> '11987654321',
            'endereco'=> 'Rua Exemplo, 123, 12345-678'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hotel
        $response = $this->post('/api/hoteis', $data);

        // Verifica erro na crianção do hotel (status HTTP 422 - Bad Request)
        $response->assertStatus(201);

        $hotelId = Hotel::latest()->first()->id;


        // Execute a solicitação de busca
        $response = $this->get("/api/hoteis/{$hotelId}");

        // Verifique se a resposta é bem-sucedida (status HTTP 200 OK)
        //$response->assertStatus(200);

        // Verifique se o id do hotel foi encontrado no banco
        $this->assertDatabaseHas('hotels', [
            'id' => $hotelId
        ]);

    }
}