<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Quarto; // Importe o modelo Quarto
use App\Models\Hotel;

class QuartosControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function cadastra_quarto_hotel_nao_existe()
    {
        $data = [
            'idHotel' => 1, 
            'qtdCamas' => 2,
            'capacidade' => 2
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/quartos', $data);

        // Verifique erro na crianção do quarto (status HTTP 404 - Recurso não foi encontrado)
        $response->assertStatus(404);

        // Verifica se a mensagem de erro é a esperada
        $response->assertJson([
            'error' => 'Hotel não encontrado.'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function sucesso_em_cadastrar_quarto()
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
            'idHotel' => 1, 
            'qtdCamas' => 2,
            'capacidade' => 2
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/quartos', $datavalue);

        // Verifique erro na crianção do quarto (status HTTP 200 - OK)
        $response->assertStatus(200);

        // Verifica se a mensagem é a esperada
        $response->assertJson([
            'message' => 'Quarto cadastrado com sucesso!'
        ]);
    }

}