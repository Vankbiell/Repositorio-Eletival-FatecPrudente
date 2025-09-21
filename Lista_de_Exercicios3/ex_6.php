<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="numero" class="form-label">Informe o numero flutuante para receber o número arredondado </label>
            <input type="number" step="any" id="numero" name="numero" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];
    if (is_numeric($numero)) {
        $resultado = round($numero);
        echo "<p>Valor arredondado: ".$resultado."</p>";
    } else {
        echo "<p>Por favor, informe um número válido!</p>";
    }
}
include ("rodape.php");
?>