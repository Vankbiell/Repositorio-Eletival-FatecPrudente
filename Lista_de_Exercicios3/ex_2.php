<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="palavra" class="form-label">Informe a palavra para receber todos a palavra com todos os caracteres em minúsculo e maiúsculo</label>
            <input type="text" id="palavra" name="palavra" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $palavra = $_POST['palavra'];
    echo "<p>Todos os caracteres em maiúsculo: ".strtoupper($palavra)."</p>"; 
    echo "<p>Todos os caracteres em minúsculo: ".strtolower($palavra)."</p>"; 
}
include ("rodape.php");
?>