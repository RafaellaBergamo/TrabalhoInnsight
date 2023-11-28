<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            color: #3498db;
        }

        .info {
            margin-top: 20px;
        }

        .info p {
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <h2>Confirmação de Reserva</h2>

        <div class="info">
            <p><strong>Nome do Hóspede:</strong> {{ $nomeHospede }}</p>
            <p><strong>Data de Check-in:</strong> {{ $reserva->dtEntrada->format('d/m/Y') }} </p>
            <p><strong>Data de Check-out:</strong> {{ $reserva->dtSaida->format('d/m/Y') }} </p>
            <p><strong>Valor:</strong> R${{ number_format($reserva->vlReserva, '2', ',') }} </p>

            <p>Estamos animados em tê-lo conosco!</p>
        </div>
    </div>

</body>
</html>
