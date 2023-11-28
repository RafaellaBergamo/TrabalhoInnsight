<?php

namespace Tests\Unit;

use App\Models\Hospede;
use App\Models\Hotel;
use App\Models\Quarto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reserva; // Importe o modelo Reserva

class PagamentosControllerTest extends TestCase
{
    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function metodo_de_pagamento_invalido()
    {
        // Cadastra funcionário
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

        // Cadastra hotel
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
        $hotelId = Hotel::latest()->first()->id;

        // Verifique erro na crianção do hotel (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra quarto
        $datavalue = [
            'idHotel' => $hotelId, 
            'qtdCamas' => 2,
            'capacidade' => 2
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/quartos', $datavalue);
        $quartoId = Quarto::latest()->first()->id;

        // Verifique erro na crianção do quarto (status HTTP 200 - OK)
        $response->assertStatus(200);

        // Cadastra hóspede
        $datavar = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $datavar);
        $hospedeId = Hospede::latest()->first()->id;

        // Verifica erro na crianção do hóspede (status HTTP 201 - Created)
        $response->assertStatus(201);
    
        // Cadastra reserva
        $dataval = [
            'idHotel' => $hotelId, 
            'idHospede' => $hospedeId,
            'idQuarto' => $quartoId,
            'qtdHospedes' => 1,
            'dtEntrada' => '01/01/2024',                
            'dtSaida' => '10/01/2024',
            'vlReserva' => 750
        ];

        // Chamada ao endpoint ou rota do Controller para criar uma reserva
        $response = $this->post('/api/reservas', $dataval);
        $reservaId = Reserva::latest()->first()->id;

        // Verifique erro na crianção do reserva (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra pagamento
        $value = [
            'idReserva' => $reservaId,
            'formaPagamento' => 'PIX'
        ];

        $response = $this->post('/api/pagamentos', $value);

        // Verifique erro na crianção do pagamento (status HTTP 201 - Created)
        $response->assertStatus(500);

        // Verifica se a mensagem de é a esperada
        $response->assertJson([
            'errors' => 'As formas de pagamento permitidas são: BOLETO, CARTAO_CREDITO, CARTAO_DEBITO ou DINHEIRO'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function reserva_nao_existe_no_banco()
    {
        // Cadastra funcionário
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

        // Cadastra hotel
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
        $hotelId = Hotel::latest()->first()->id;

        // Verifique erro na crianção do hotel (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra quarto
        $datavalue = [
            'idHotel' => $hotelId, 
            'qtdCamas' => 2,
            'capacidade' => 2
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/quartos', $datavalue);
        $quartoId = Quarto::latest()->first()->id;

        // Verifique erro na crianção do quarto (status HTTP 200 - OK)
        $response->assertStatus(200);

        // Cadastra hóspede
        $datavar = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $datavar);
        $hospedeId = Hospede::latest()->first()->id;

        // Verifica erro na crianção do hóspede (status HTTP 201 - Created)
        $response->assertStatus(201);
    
        // Cadastra reserva
        $dataval = [
            'idHotel' => $hotelId, 
            'idHospede' => $hospedeId,
            'idQuarto' => $quartoId,
            'qtdHospedes' => 1,
            'dtEntrada' => '01/01/2024',                
            'dtSaida' => '10/01/2024',
            'vlReserva' => 750
        ];

        // Chamada ao endpoint ou rota do Controller para criar uma reserva
        $response = $this->post('/api/reservas', $dataval);
        $reservaId = Reserva::latest()->first()->id;

        // Verifique erro na crianção do reserva (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra pagamento
        $value = [
            'idReserva' => '5',
            'formaPagamento' => 'BOLETO'
        ];

        $response = $this->post('/api/pagamentos', $value);

        // Verifique erro na crianção do pagamento (status HTTP 201 - Created)
        $response->assertStatus(500);

        // Verifica se a mensagem de é a esperada
        $response->assertJson([
            'errors' => 'Pagamento não pode ser efetuado. Por favor, verifique se o id da reserva está correto.'
        ]);
    }

    use RefreshDatabase; // Utiliza transações e rollback
    /** @test */
    public function cadastra_pagamento_sucesso()
    {
        // Cadastra funcionário
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

        // Cadastra hotel
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
        $hotelId = Hotel::latest()->first()->id;

        // Verifique erro na crianção do hotel (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra quarto
        $datavalue = [
            'idHotel' => $hotelId, 
            'qtdCamas' => 2,
            'capacidade' => 2
        ];

        // Chamada ao endpoint ou rota do Controller para criar um quarto
        $response = $this->post('/api/quartos', $datavalue);
        $quartoId = Quarto::latest()->first()->id;

        // Verifique erro na crianção do quarto (status HTTP 200 - OK)
        $response->assertStatus(200);

        // Cadastra hóspede
        $datavar = [
            'nome' => 'Nome Hospede',
            'email' => 'hospe@example.com',
            'telefone' => '11965924467',
            'cpf' => '98781004052'
        ];

        // Chamada ao endpoint ou rota do Controller para criar um hóspede
        $response = $this->post('/api/hospedes', $datavar);
        $hospedeId = Hospede::latest()->first()->id;

        // Verifica erro na crianção do hóspede (status HTTP 201 - Created)
        $response->assertStatus(201);
    
        // Cadastra reserva
        $dataval = [
            'idHotel' => $hotelId, 
            'idHospede' => $hospedeId,
            'idQuarto' => $quartoId,
            'qtdHospedes' => 1,
            'dtEntrada' => '01/01/2024',                
            'dtSaida' => '10/01/2024',
            'vlReserva' => 750
        ];

        // Chamada ao endpoint ou rota do Controller para criar uma reserva
        $response = $this->post('/api/reservas', $dataval);
        $reservaId = Reserva::latest()->first()->id;

        // Verifique erro na crianção do reserva (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Cadastra pagamento
        $value = [
            'idReserva' => $reservaId,
            'formaPagamento' => 'BOLETO'
        ];

        $response = $this->post('/api/pagamentos', $value);

        // Verifique erro na crianção do pagamento (status HTTP 201 - Created)
        $response->assertStatus(201);

        // Verifica se a mensagem de é a esperada
        $response->assertJson([
            'message' => 'Pagamento efetuado com sucesso! Um email com os dados do pagamento foi enviado para o email cadastrado.'
        ]);
    }
}