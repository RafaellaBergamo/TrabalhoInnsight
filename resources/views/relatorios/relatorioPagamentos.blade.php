<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pagamentos</title>
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
        <header>
            <h1>Relatório de Pagamentos</h1>
        </header>

        <section>
            <table>
                <thead>
                    <tr>
                        <th>ID Pagamento</th>
                        <th>ID Hóspede</th>
                        <th>ID Reserva</th>
                        <th>Data de Pagamento</th>
                        <th>Forma de Pagamento</th>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagamentos as $pagamento)
                        <tr>
                            <td>{{ $pagamento['id'] }}</td>
                            <td>{{ $pagamento['idHospede'] }}</td>
                            <td>{{ $pagamento['idReserva'] }}</td>
                            <td>{{ $pagamento['dtPagamento'] }}</td>
                            <td>{{ $pagamento['formaPagamento'] }}</td>
                            <!-- Adicione mais colunas conforme  necessário -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
