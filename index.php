<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Metatags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Exemplo de Procedure</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main>
        <div id="controls">
            <button id="btn-calculo-manual" disabled>Cálculo Manual</button>
            <button id="btn-acessar">Acessar</button>
            <button id="btn-calculo-procedure" disabled>Cálculo usando Procedure</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Data</th>
                    <th>Idade</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Sexo</th>
                    <th>IMC</th>
                    <th>Taxa de Metabolismo Basal</th>
                </tr>
            </thead>

            <tbody id="dados"></tbody>
        </table>
    </main>

    <!-- jQuery -->
    <script src="assets/third/jquery-3.7.0.min.js"></script>

    <!-- JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>