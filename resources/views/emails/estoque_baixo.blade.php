<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Estoque Baixo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #ffffff;
            color: #333;
            padding-top: 20px;
            min-height: 70px;
            border-bottom: #bbb 1px solid;
        }

        header a {
            color: #333;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        header ul {
            padding: 0;
            margin: 0;
            list-style: none;
            overflow: hidden;
        }

        header #logo {
            text-align: left;
        }

        header #logo img {
            height: 70px;
            width: auto;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        header #logo a img {
            border: 0;
        }

        header nav {
            float: right;
            margin-top: 10px;
        }

        header .main-nav ul {
            list-style: none;
            overflow: hidden;
        }

        header .main-nav li {
            float: left;
            display: inline;
            margin: 0 20px 0 20px;
        }

        header .main-nav li a {
            color: #333;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        header .main-nav li a:hover {
            color: #007991;
            transition: color 0.3s ease-in-out;
        }

        .main {
            padding: 0 0 40px 0;
        }

        .main h1 {
            color: #333;
        }

        .main p {
            font-size: 18px;
            line-height: 1.6em;
            color: #666;
        }

        .button {
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            margin: 20px 0;
            text-decoration: none;
            background-color: #007991;
            color: #fff;
            border-radius: 5px;
        }

        footer {
            background: #007991;
            color: #fff;
            padding-top: 30px;
            padding-bottom: 30px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container main">
        <h1>Alerta de Estoque Baixo</h1>
        <p>O produto {{ $produto->descricao }} está com estoque baixo no hotel {{ $produto->idHotel }}. Atualmente, temos apenas {{ $produto->qtdProduto }} unidades disponíveis.</p>
    </div>
</body>
</html>
