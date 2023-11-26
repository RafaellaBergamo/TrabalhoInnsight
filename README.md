API desenvolvida para a disciplina de Implementação de Sistemas de Informação da UNESP - Bauru

## Cadastrar Hotéis

Cadastra um novo hotel na plataforma.

### Endpoint

`POST /api/hoteis`

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

`PUT http://localhost:8000/api/hoteis`

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

`GET http://localhost:8000/api/hoteis`

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

