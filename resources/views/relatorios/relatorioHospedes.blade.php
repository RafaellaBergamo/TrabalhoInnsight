<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Hóspedes</title>
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

    <header>
        <h1>Relatório de Hóspedes</h1>
    </header>

    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data de entrada:</th>
                    <th>Data de saída:</th>
                    <th>Valor:</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hospedes as $key => $hospede)
                    <tr>
                        <td>{{ $hospede['id'] }}</td>
                        <td>{{ $hospede['nome'] }}</td>
                        <td>{{ $hospede['dtEntrada'] }}</td>
                        <td>{{ $hospede['dtSaida'] }}</td>
                        <td>{{ R$ number_format($hospede['vlReserva'], 2, ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

</body>
</html>
