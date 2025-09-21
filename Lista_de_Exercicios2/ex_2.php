<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor1" class="form-label">Informe o primeiro valor</label>
            <input type="number" id="valor1" name="valor1" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="valor2" class="form-label">Informe o segundo valor</label>
            <input type="number" id="valor2" name="valor2" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $valor1 = $_POST['valor1'];
    $valor2 = $_POST['valor2'];
    if ($valor1 == $valor2){
        $soma = $valor1 + $valor2;
        $triplo = $soma * 3;
        echo "Os dois valores são iguais então o tiplo da soma é: $triplo";
    }
    else{
        $soma = $valor1 + $valor2;
        echo"A soma dos dois números é: $soma";
    }
}
include ("rodape.php");
?>