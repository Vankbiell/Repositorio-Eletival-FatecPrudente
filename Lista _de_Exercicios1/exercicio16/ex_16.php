<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 16 - Calcular o percentual de desconto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercício 16 - Calcular o percentual de desconto</h1>
<form method="post">
<div class="mb-3">
              <label for="preco" class="form-label">Informe um preço</label>
              <input type="number" id="preco" name="preco" class="form-control" required="">
            </div><div class="mb-3">
              <label for="percentual_desconto" class="form-label">Informe o percentual de desconto</label>
              <input type="number" id="percentual_desconto" name="percentual_desconto" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $preco = $_POST["preco"];
        $percentual_desconto = $_POST["percentual_desconto"];
        $desconto = $preco * ($percentual_desconto / 100);
        $preco_novo = $preco - $desconto;
        echo "O preço novo com percentual de aumento é de $preco_novo";

    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>