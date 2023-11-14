<!DOCTYPE html>
<html>
<head>
    <title> <h1>Confirmação de Reserva</h1> </title>
</head>
<body>
    <p> {{ $mensagem }} </p>

    <p>Detalhes da Reserva:</p>
    <ul>
        <li>Data de Check-in: {{ $reserva->dtEntrada->format('d/m/Y') }}</li>
        <li>Data de Check-out: {{ $reserva->dtSaida->format('d/m/Y') }}</li>
        <li>Valor: R${{ number_format($reserva->vlReserva, 2, ',') }}</li>
    </ul>

    <p>Obrigado por escolher a Innsight!</p>
</body>
</html>
