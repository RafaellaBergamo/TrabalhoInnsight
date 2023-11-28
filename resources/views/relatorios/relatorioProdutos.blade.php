<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            text-align: center;
            padding: 20px 0;
            background-color: #3498db;
            color: #fff;
        }

        h1 {
            margin: 0;
        }

        section {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Relatório de Produtos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Produto</th>
                    <th>Descrição</th>
                    <th>ID Hotel</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQuantidade = 0;
                @endphp

                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto['id'] }}</td>
                        <td>{{ $produto['descricao'] }}</td>
                        <td>{{ $produto['idHotel'] }}</td>
                        <td>{{ $produto['qtdProduto'] }}</td>
                    </tr>

                    @php
                        $totalQuantidade += $produto['qtdProduto'];
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <footer style="text-align: right;">Total de Produtos: {{ $totalQuantidade }}</footer>
    </div>
</body>
</html>
