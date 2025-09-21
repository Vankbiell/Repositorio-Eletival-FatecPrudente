<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="numero" class="form-label">Informe o numero flutuante para receber o numewro arredondado </label>
            <input type="number" id="numero" name="numero" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];
    echo "<p>Valor arredondado:".round($numero)."</p>";
}
include ("rodape.php");
?>