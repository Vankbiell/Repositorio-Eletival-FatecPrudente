<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="numero1" class="form-label">Informe o primeiro número</label>
            <input type="number" id="numero1" name="numero1" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="numero2" class="form-label">Informe o segundo número</label>
            <input type="number" id="numero2" name="numero2" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $numero1 = $_POST['numero1'];
    $numero1 = $_POST['numero1'];

    if ($numero1 == $numero1)
        echo "Os valores sâo iguais: $numero1";
    elseif ($numero1 > $numero2)
        echo " O valor A é o maior, $numero1,$numero2";
    else
        echo " O valor B é o maior, $numero2,$numero1";
}
include ("rodape.php");
?>