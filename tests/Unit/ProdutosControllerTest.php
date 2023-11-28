<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produto; // Importe o modelo Produto
use App\Models\Hotel;

class ProdutosControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function cadastra_produto_hotel_nao_existe()
    {
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
        
        $response->assertStatus(201);

        $datavalue = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario' => '123456',
            'idHotel' => 1,
            'descricao' => 'Kit banho',
            'qtdProduto' => '80'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/produtos', $datavalue);

        // Verifique erro na crianção do produto (status HTTP 422 - Bad Request)
        $response->assertStatus(404);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => 'Hotel não encontrado.'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function funcionario_nao_tem_permissao_para_cadastrar_produto()
    {
        $dados = [
            'nome' => 'Nome Funcionario',
            'email' => 'funcio@example.com',
            'telefone' => '11965924467',
            'senha' => '123456',
            'tipo' => 0,
            'cpf' => '71316897001'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um funcionário
        $response = $this->post('/api/funcionarios', $dados);
        
        $response->assertStatus(201);

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

        // Verifique erro na crianção do produto (status HTTP 422 - Bad Request)
        $response->assertStatus(422);

        $datavalue = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario' => '123456',
            'idHotel' => 1,
            'descricao' => 'Kit banho',
            'qtdProduto' => '80'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/produtos', $datavalue);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'errors' => 'Funcionário sem acesso.'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function sucesso_em_cadastrar_produto()
    {
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
        
        $response->assertStatus(201);

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

        $datavalue = [
            'emailFuncionario' => 'funcio@example.com',
            'senhaFuncionario' => '123456',
            'idHotel' => 1,
            'descricao' => 'Kit banho',
            'qtdProduto' => '80'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um produto
        $response = $this->post('/api/produtos', $datavalue);

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'message' => 'Produto cadastrado com sucesso!'
        ]);
    }

}