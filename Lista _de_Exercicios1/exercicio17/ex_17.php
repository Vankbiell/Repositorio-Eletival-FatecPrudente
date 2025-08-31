<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 17 - Calcule o juros simples</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercício 17 - Calcule o juros simples</h1>
<form method="post">
<div class="mb-3">
              <label for="capital" class="form-label">Informe o capital</label>
              <input type="number" step="0.01" id="capital" name="capital" class="form-control" required="">
            </div><div class="mb-3">
              <label for="tx_juros" class="form-label">Informe a taxa de juros</label>
              <input type="number" id="tx_juros" name="tx_juros" class="form-control" required="">
            </div><div class="mb-3">
              <label for="periodo" class="form-label">Informe o período</label>
              <input type="number" id="periodo" name="periodo" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $capital = $_POST["capital"];
        $tx_juros = $_POST["tx_juros"];
        $periodo = $_POST["periodo"];
        $taxa_decimal = $tx_taxa / 100;
        $juros = $capital * $taxa_decimal * $periodo;
        echo "O valor da taxa de juros $tx_juros";

    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>