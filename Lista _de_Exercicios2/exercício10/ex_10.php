<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 10 - Calculo do perímetro de um retângulo </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercício 10 - Calculo do perímetro de um retângulo </h1>
<form method="post">
<div class="mb-3">
              <label for="altura" class="form-label">Informe a altura </label>
              <input type="number" id="altura" name="altura" class="form-control" required="">
            </div><div class="mb-3">
              <label for="largura" class="form-label">Informe a largura</label>
              <input type="number" id="largura" name="largura" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $altura = $_POST["altura"];
    $largura = $_POST["largura"];
    $perimetro = 2 * ($altura + $largura);
    echo "O valor do perímeto é $perimetro";
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>