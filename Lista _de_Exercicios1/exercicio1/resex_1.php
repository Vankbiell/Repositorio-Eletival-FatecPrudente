<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lista de Exercícios 1 - Exercício 1</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
    <div class = "conatainer">
        <?php
            $valor1 = $_POST["valor1"];
            $valor2 = $_POST["valor2"];
            $soma = $valor1 + $valor2;
            echo "<h1>Soma: $soma </h1>";
            echo '<button type="button" onclick="history.back()" class="btn btn-primary">Voltar</button>'
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>