<!DOCTYPE html>
<head>
    <title>Comprovante de Pagamento</title>
</head>
<body>
    <p>Este comprovante é emitido para comprovar o pagamento da sua reserva.</p>

    <p>
        <strong>Hóspede:</strong> {{ $nomeHospede }}
    </p>

    <p>
        <strong>Valor:</strong> R${{ number_format($vlTotal, 2, ',') }}
    </p>

    <p>
        <strong>Forma de pagamento:</strong> {{ $formaPagamento }}
    </p>

    <p>
        <strong>Data:</strong> {{ $dtPagamento }}
    </p>
</body>
</html>