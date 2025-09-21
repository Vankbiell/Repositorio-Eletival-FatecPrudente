<?php
include("cabecalho.php");
    $valor = 10;
    
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o número para receber a soma de 1 até o número informado</label>
            <input type="number" id="valor" name="valor" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $valor = $_POST['valor'];
    $total = 0;
    $i = 1;
    while($i <= $valor){
        $total += $i;
        $i++;
    }
    echo "<p>Total: $total</p>";
}
include("rodape.php");
?>