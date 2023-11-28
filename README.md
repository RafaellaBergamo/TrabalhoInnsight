API desenvolvida para a disciplina de Implementação de Sistemas de Informação da UNESP - Bauru

# Cadastrar Funcionário

Cadastra um novo funcionário na plataforma.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/funcionarios`

## Parâmetros de Requisição

Enviar como payload JSON:

- `nome` (obrigatório, tipo: string): Nome do funcionário.
- `cpf` (obrigatório, tipo: string): CPF do funcionário (apenas números).
- `tipo` (opcional, tipo: integer): Tipo de funcionário (0 - COMUM, 1 - GOVERNANCA, 2 - MASTER).
- `telefone` (obrigatório, tipo: string): Número de telefone do funcionário (apenas números, com DDD).
- `email` (obrigatório, tipo: string): Email do funcionário.
- `senha` (obrigatório, tipo: string): Senha do funcionário (mínimo de 6 caracteres)

Exemplo de Requisição:

```json
{
  "nome": "Nome do Funcionário",
  "cpf": "12345678901",
  "tipo": 1,
  "telefone": "11987654321",
  "email": "funcionario@example.com",
  "senha": "senha123"
}
```
# Atualizar Funcionário

Atualiza informações de um funcionário existente na plataforma.

## Endpoint

`PUT https://innsight-e19951768fbc.herokuapp.com/api/funcionarios/{id}`

## Parâmetros de Requisição

Enviar como payload JSON:

- `nome` (opcional, tipo: string): Novo nome do funcionário.
- `cpf` (opcional, tipo: string): Novo CPF do funcionário (apenas números).
- `tipo` (opcional, tipo: integer): Novo tipo de funcionário (0 - COMUM, 1 - GOVERNANCA, 2 - MASTER).
- `telefone` (opcional, tipo: string): Novo número de telefone do funcionário (apenas números, com DDD).
- `email` (opcional, tipo: string): Novo email do funcionário.
- `senha` (opcional, tipo: string): Nova senha do funcionário (mínimo de 6 caracteres).

Exemplo de Requisição:

```json
{
  "nome": "Novo Nome do Funcionário",
  "cpf": "98765432109",
  "tipo": 2,
  "telefone": "11998765432",
  "email": "novoemail@example.com",
  "senha": "novasenha123"
}
```

# Buscar Funcionário por ID

Recupera informações sobre um funcionário específico na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/funcionarios`

## Parâmetros de Requisição

- `id` (obrigatório, tipo: integer): ID do funcionário para busca específica.

## Exemplo de Requisição

`GET http://localhost:8000/api/funcionarios/1`

## Resposta de Sucesso

Status: 200 OK

```json
{
  "idFuncionario": 1,
  "nome": "Nome do Funcionário",
  "cpf": "12345678901",
  "tipo": 1,
  "telefone": "11987654321",
  "email": "funcionario@example.com",
  "idHotel": 1
}
```

## Cadastrar Hotéis

Cadastra um novo hotel na plataforma.

### Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/hoteis`

### Parâmetros de Requisição

- `emailFuncionario` (obrigatório, tipo: email): Email do funcionário com acesso master para cadastro de hotéis.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário com acesso master.
- `cnpj` (obrigatório, tipo: string): CNPJ do hotel (apenas números).
- `razaoSocial` (obrigatório, tipo: string): Razão social do hotel.
- `qtdQuartos` (obrigatório, tipo: integer): Quantidade de quartos do hotel.
- `telefone` (obrigatório, tipo: string): Número de telefone do hotel (apenas números, com DDD).
- `endereco` (obrigatório, tipo: string): Endereço do hotel contendo rua, número e CEP no formato XXXXX-XXX.

### Exemplo de Requisição

```json
{
  "emailFuncionario": "admin@example.com",
  "senhaFuncionario": "senha123",
  "cnpj": "28324061000123",
  "razaoSocial": "Hotel Exemplo",
  "qtdQuartos": 50,
  "telefone": "11987654321",
  "endereco": "Rua Exemplo, 123, 12345-678"
}
```

# Atualizar Hotel

Atualiza informações de um hotel existente na plataforma.

## Endpoint

`PUT https://innsight-e19951768fbc.herokuapp.com/api/hoteis/`

## Parâmetros de Requisição

- `emailFuncionario` (obrigatório, tipo: email): Email do funcionário com acesso master para atualização de hotéis.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário com acesso master.
- `idHotel` (obrigatório, tipo: integer): ID do hotel que será atualizado.
- `cnpj` (opcional, tipo: string): CNPJ do hotel (apenas números).
- `razaoSocial` (opcional, tipo: string): Razão social do hotel.
- `qtdQuartos` (opcional, tipo: integer): Quantidade de quartos do hotel.
- `telefone` (opcional, tipo: string): Número de telefone do hotel (apenas números, com DDD).
- `endereco` (opcional, tipo: string): Endereço do hotel contendo rua, número e CEP no formato XXXXX-XXX.

## Exemplo de Requisição

```json
{
  "emailFuncionario": "admin@example.com",
  "senhaFuncionario": "senha123",
  "idHotel": 1,
  "cnpj": "12345678901234",
  "razaoSocial": "Novo Nome Hotel",
  "qtdQuartos": 60,
  "telefone": "11987654321",
  "endereco": "Rua Atualizada, 456, 54321-876"
}
```

# Buscar Hotéis

Recupera informações sobre hotéis cadastrados na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/hoteis`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (opcional, tipo: integer): ID do hotel para busca específica.
- `razaoSocial` (opcional, tipo: string): Razão social do hotel para busca específica.

Exemplo de Requisição:

```json
{
  "idHotel": 1
}
```

# Cadastrar Quarto

Cadastra um quarto pra um hotel

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/quartos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (obrigatório, tipo: integer): id do hotel.
- `qtdCamas` (obrigatório, tipo: integer): Quantas camas tem o quarto.
- `capacidade` (obrigatório, tipo: integer): Quantos hóspedes o quarto comporta.

Exemplo de Requisição:

```json
{
    "idHotel": 1,
    "qtdCamas": 2,
    "capacidade": 4
}
```
# Buscar Quarto

Recupera informações sobre um quarto específico na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/quartos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (obrigatório, tipo: integer): ID do hotel ao qual quero buscar os quartos.
- `idQuarto` (opcional, tipo: integer): ID do quarto para busca específica.

Exemplo de Requisição:

```json
{
  "idHotel": 1
}
```

# Buscar Quartos por Status

Recupera informações sobre quartos com um status específico em um hotel na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/quartos/status`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (obrigatório, tipo: integer): ID do hotel para busca específica.
- `status` (obrigatório, tipo: string): Status do quarto ("disponível", "sujo", "ocupado").

Exemplo de Requisição:

```json
{
  "idHotel": 1,
  "status": "disponível"
}
```
# Cadastrar Hóspede

Cadastra um novo hóspede na plataforma.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/hospedes`

## Parâmetros de Requisição

Enviar como payload JSON:

- `nome` (obrigatório, tipo: string): Nome do hóspede.
- `cpf` (obrigatório, tipo: string): CPF do hóspede (apenas números).
- `telefone` (obrigatório, tipo: string): Número de telefone do hóspede (apenas números, com DDD).
- `email` (obrigatório, tipo: string): Email do hóspede.

Exemplo de Requisição:

```json
{
  "nome": "Nome do Hóspede",
  "cpf": "12345678901",
  "telefone": "11987654321",
  "email": "hospede@example.com"
}
```
# Atualizar Hóspede

Atualiza informações de um hóspede existente na plataforma.

## Endpoint

`PUT https://innsight-e19951768fbc.herokuapp.com/api/hospedes`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHospede` (obrigatório, tipo: integer): ID do hóspede que será atualizado.
- `nome` (opcional, tipo: string): Novo nome do hóspede.
- `cpf` (opcional, tipo: string): Novo CPF do hóspede (apenas números).
- `telefone` (opcional, tipo: string): Novo número de telefone do hóspede (apenas números, com DDD).
- `email` (opcional, tipo: string): Novo email do hóspede.

Exemplo de Requisição:

```json
{
  "idHospede": 1,
  "nome": "Novo Nome do Hóspede",
  "cpf": "98765432109",
  "telefone": "11998765432",
  "email": "novoemail@example.com"
}
```
# Buscar Hóspedes

Recupera informações sobre hóspedes cadastrados na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/hospedes`

## Parâmetros de Requisição

Enviar como payload JSON:

- `nomeHospede` (opcional, tipo: string): Nome do hóspede para busca específica.

Exemplo de Requisição:

```json
{
  "nomeHospede": "Nome do Hóspede"
}
```
# Buscar Hóspede por ID

Recupera informações sobre um hóspede específico na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/hospedes/{id}`

## Parâmetros de Requisição

- `id` (obrigatório, tipo: integer): ID do hóspede para busca específica.

## Exemplo de Requisição

`GET https://innsight-e19951768fbc.herokuapp.com/api/hospedes/1`

## Resposta de Sucesso

Status: 200 OK

```json
{
  "idHospede": 1,
  "nome": "Nome do Hóspede",
  "cpf": "12345678901",
  "telefone": "11987654321",
  "email": "hospede@example.com"
}
```
# Cadastrar Funcionário

Cadastra um novo funcionário na plataforma.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/funcionarios`

## Parâmetros de Requisição

Enviar como payload JSON:

- `nome` (obrigatório, tipo: string): Nome do funcionário.
- `cpf` (obrigatório, tipo: string): CPF do funcionário (apenas números).
- `tipo` (opcional, tipo: integer): Tipo de funcionário (0 - COMUM, 1 - GOVERNANCA, 2 - MASTER).
- `telefone` (obrigatório, tipo: string): Número de telefone do funcionário (apenas números, com DDD).
- `email` (obrigatório, tipo: string): Email do funcionário.
- `senha` (obrigatório, tipo: string): Senha do funcionário (mínimo de 6 caracteres)

Exemplo de Requisição:

```json
{
  "nome": "Nome do Funcionário",
  "cpf": "12345678901",
  "tipo": 1,
  "telefone": "11987654321",
  "email": "funcionario@example.com",
  "senha": "senha123"
}
```

## Cadastrar Reserva

Endpoint para cadastrar uma nova reserva.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/reservas`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (obrigatório, tipo: integer): Id do hotel onde vai ser a reserva.
- `idHospede` (obrigatório, tipo: integer): id do Hóspede.
- `idQuarto` (obrigatório, tipo: integer): Id do hóspede da reserva.
- `qtdHospedes` (obrigatório, tipo: integer): Quantidade de pessoas na reserva.
- `dtEntrada` (obrigatório, tipo: date): Data de entrada da reserva (d/m/Y).
- `dtSaida` (obrigatório, tipo: date): Data de saída da reserva (d/m/Y).
- `vlReserva` (obrigatório, tipo: float): Valor total da reserva

Exemplo de Requisição:
  ```json
  {
      "idHotel": 1,
      "idHospede": Exemplo Hóspede,
      "idQuarto": 1,
      "qtdHospedes": 2,
      "dtEntrada": 27/11/2023,
      "dtSaida":  30/11/2023,
      "vlReserva": 750
  }
  ```
## Buscar Reserva

Endpoint para buscar uma reserva específica pelo ID.

## Endpoint

  `GET https://innsight-e19951768fbc.herokuapp.com/api/reservas/{id}`

## Atualizar Reserva

Endpoint para atualizar uma reserva existente.

## Endpoint

  `PUT https://innsight-e19951768fbc.herokuapp.com/api/reservas`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idReserva` (obrigatório, tipo: integer): Id da reserva a ser atualizada.
- `idHotel` (opcional, tipo: integer): Id do hotel onde vai ser a reserva.
- `idHospede` (opcional, tipo: integer): id do Hóspede.
- `idQuarto` (opcional, tipo: integer): Id do hóspede da reserva.
- `qtdHospedes` (opcional, tipo: integer): Quantidade de pessoas na reserva.
- `dtEntrada` (opcional, tipo: date): Data de entrada da reserva (d/m/Y).
- `dtSaida` (opcional, tipo: date): Data de saída da reserva (d/m/Y).
- `vlReserva` (opcional, tipo: float): Valor total da reserva

Exemplo de Requisição:

  ```json
  {
      "idReserva": 1.
      "idHotel": 1,
      "idHospede": Exemplo Hóspede Novo,
      "idQuarto": 1,
      "qtdHospedes": 2,
      "dtEntrada": 27/11/2023,
      "dtSaida":  30/11/2023,
      "vlReserva": 750
  }
  ```

# Cadastrar Produtos

Cadastra novos produtos na plataforma.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/produtos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `emailFuncionario` (obrigatório, tipo: string): Email do funcionário responsável pelo cadastro. Apenas funcionários MASTER ou GOVERNANÇA têm acesso.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário.
- `idHotel` (obrigatório, tipo: integer): ID do hotel onde os produtos serão cadastrados.
- `descricao` (obrigatório, tipo: string): Descrição do produto.
- `qtdProduto` (obrigatório, tipo: integer): Quantidade do produto a ser cadastrada.

Exemplo de Requisição:

```json
{
  "emailFuncionario": "funcionario@example.com",
  "senhaFuncionario": "senhasecreta",
  "idHotel": 1,
  "descricao": "Novo Produto",
  "qtdProduto": 10
}
```
# Buscar Produto

Busca informações sobre produtos na plataforma.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/produtos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `emailFuncionario` (obrigatório, tipo: string): Email do funcionário responsável pela busca. Apenas funcionários MASTER ou GOVERNANÇA têm acesso.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário.
- `idProduto` (opcional, tipo: integer): ID do produto a ser buscado.
- `descricao` (opcional, tipo: string): Descrição do produto a ser buscado.
- `idHotel` (opcional, tipo: integer): Hotel a qual o produto pertence.

Exemplo de Requisição:

```json
{
  "emailFuncionario": "funcionario@example.com",
  "senhaFuncionario": "senhasecreta",
  "descricao": "Produto Buscado"
}
```

# Atualizar Produto

Atualiza informações de um produto existente na plataforma.

## Endpoint

`PUT https://innsight-e19951768fbc.herokuapp.com/api/produtos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `emailFuncionario` (obrigatório, tipo: string): Email do funcionário responsável pela atualização. Apenas funcionários MASTER ou GOVERNANÇA têm acesso.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário.
- `idProduto` (obrigatório, tipo: integer): ID do produto que será atualizado.
- `idHotel` (opcional, tipo: integer): Novo ID do hotel associado ao produto.
- `descricao` (opcional, tipo: string): Nova descrição do produto.
- `qtdProduto` (opcional, tipo: integer): Nova quantidade do produto.

Exemplo de Requisição:

```json
{
  "emailFuncionario": "funcionario@example.com",
  "senhaFuncionario": "senhasecreta",
  "idProduto": 1,
  "idHotel": 2,
  "descricao": "Produto Atualizado",
  "qtdProduto": 20
}
```

# Fazer Check-in

Registra o check-in de um hóspede no hotel.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/registros/checkin`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idReserva` (obrigatório, tipo: integer): ID da reserva associada ao check-in.

**Exemplo de Requisição:**
```json
{
  "idReserva": 123
}
```

# Fazer Check-out

Registra o check-out de um hóspede do hotel.

## Endpoint

`POST https://innsight-e19951768fbc.herokuapp.com/api/registros/checkout`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idReserva` (obrigatório, tipo: integer): ID da reserva associada ao check-out.

**Exemplo de Requisição:**
```json
{
  "idReserva": 123
}
```

# Relatório de Hóspedes Atualmente Hospedados no Hotel

Obtém um relatório dos hóspedes atualmente hospedados no hotel.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/relatorios/hospedes`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (obrigatório, tipo: integer): ID do hotel.
- `emailFuncionario` (obrigatório, tipo: string): Email do funcionário autorizado.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário autorizado.

**Exemplo de Requisição:**
```json
{
    "idHotel": 1,
    "emailFuncionario": "funcionario@hotel.com",
    "senhaFuncionario": "senha123"
}
```

# Relatório de Produtos

Obtém um relatório de produtos.

## Endpoint

`GET https://innsight-e19951768fbc.herokuapp.com/api/relatorios/produtos`

## Parâmetros de Requisição

Enviar como payload JSON:

- `idHotel` (opcional, tipo: integer): ID do hotel.
- `idProduto` (opcional, tipo: integer): ID do produto.
- `descricao` (opcional, tipo: string): Descrição do produto.
- `emailFuncionario` (obrigatório, tipo: string): Email do funcionário autorizado.
- `senhaFuncionario` (obrigatório, tipo: string): Senha do funcionário autorizado.

**Exemplo de Requisição:**
```json
{
    "idHotel": 1,
    "idProduto": 101,
    "descricao": "Produto A",
    "emailFuncionario": "funcionario@hotel.com",
    "senhaFuncionario": "senha123"
}
```

# Testes Unitários

## Configuração de Ambiente

- Copiar pasta do arquivo para a pasta "www" do Laragon.
- Iniciar Laragon.
- Abrir terminal do Laragon.
- Inserir os comandos:
```cd caminho_da_pasta_TrabalhoInnsight```
```composer install```
```php artisan migrate```
```php artisan serve```

## Execução dos testes

- Abra outro terminal além do que está aberto.
- Insira o comando:
```cd caminho_da_pasta_TrabalhoInnsight```
- Para executar todos os testes use o comando:
```php artisan test```
- Para executar uma classe use o comando:
```php artisan test tests/Unit/NomeDaClasseDeTeste.php```