<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lista de Exercícios 1 - Exercício 4</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
    <div class = "conatainer mt-4">
        <?php
        $valor1 = $_POST["valor1"];
        $valor2 = $_POST["valor2"];
            if (($valor1 && $valor2) != 0){
                $divisao = $valor1 / $valor2;
                echo "<h1>Divisão: $divisao </h1>";
                echo '<button type="button" onclick="history.back()" class="btn btn-primary">Voltar</button>';
            }
            else{
                echo "<h1>Algum dos valores é igual a zero.</h1>";
            }
        //git config --global user.email "you@example.com"
        //git config --global user.name ""
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>