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
        $celsius = $_POST["celsius"];
        $fahrenheit = ($celsius * 1.8) + 32;
        echo "{$celsius}°C = {$fahrenheit}°F";
        echo '<button type="button" onclick="history.back()" class="btn btn-primary">Voltar</button>'




        //git config --global user.email "you@example.com"
        //git config --global user.name ""
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>