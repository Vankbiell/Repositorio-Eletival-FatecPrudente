<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o valor</label>
            <input type="number" id="valor" name="valor" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $valor = $_POST['valor'];
    if ($valor > 100){
        $valor -= ($valor * (15 / 100));
        echo" <p>O valor do produto é maior que 100 reais então é aplicado o desconto de 15%</p>";
        echo" <p>O valor do produto como o desconto aplicado é $valor </p>";
    }
    else{
        echo "<p>O valor nâo tem desconto</p>";
        echo "<p> O valor é $valor</p>";
    }
}
include("rodape.php");
?>