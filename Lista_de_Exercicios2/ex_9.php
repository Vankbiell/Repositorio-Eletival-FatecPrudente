<?php
include("cabecalho.php");
    $numero = $_POST['numero'];
    $fatorial = $numero;
    for($i=$numero-1;$i>1;$i--){
        $fatorial = $fatorial * $i;
        //$fatorial *= $i;
    }
    echo "O fatorial de $numero é: $fatorial";

?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="numero" class="form-label">Informe o Número</label>
            <input type="number" id="numero" name="numero" class="form-control" required="">
        </div>
    </form>
</div>
<?php
    include ("rodape.php");
?>