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
