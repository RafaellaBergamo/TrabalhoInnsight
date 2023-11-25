<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .comprovante {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        .dados {
            margin-top: 20px;
        }

        .dados span {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="comprovante">
        <h1>Comprovante de Pagamento</h1>

        <div class="dados">
            <span><strong>Hóspede:</strong> {{ $nomeHospede }} </span>
            <span><strong>Valor Pago:</strong> R${{ number_format($vlTotal, 2, ',') }} </span>
            <span><strong>Forma Pagamento:</strong> {{ $formaPagamento }} </span>
            <span><strong>Data do Pagamento:</strong> {{ $dtPagamento }} </span>
            <!-- Adicione mais informações conforme necessário -->
        </div>
    </div>

</body>
</html>
