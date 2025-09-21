<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="palavra" class="form-label">Informe a palavra para receber a quantidade de caracteres </label>
            <input type="text" id="palavara" name="palavra" class="form-control" required="">
        </div>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $palavra = $_POST['palavra'];
    echo "<p>Quantidade de caracteres da palavra:".strlen($palavra)."</p>";
}
include ("rodape.php");
?>