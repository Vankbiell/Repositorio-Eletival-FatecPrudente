<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="raiz" class="form-label">Informe o número que você quer saber a raiz </label>
            <input type="number" id="raiz" name="raiz" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $raiz = $_POST['raiz'];
    echo "<p>Raiz quadrada de $raiz: ".sqrt($raiz)."</p>";
}
include ("rodape.php");
?>