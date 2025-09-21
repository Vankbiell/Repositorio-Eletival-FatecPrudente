
<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o número para receber uma lista de 1 até seu número.</label>
            <input type="number" id="valor" name="valor" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $valor = $_POST['valor'];
    for($i=1; $i<=$valor; $i++){
        echo"<p> Número $i</p>";
    }
}
include("rodape.php");
?>