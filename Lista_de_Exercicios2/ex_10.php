
<?php
include("cabecalho.php");

        $valor = $_POST['valor'];
        echo"<h1>Tabuada</h1>";
        for($i=1; $i<=10; $i++){
            $resultado = $valor * $i;
            echo"<p>$valor X $i = $resultado</p>";
        }
?>

<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o 1º valor</label>
            <input type="number" id="valor" name="valor" class="form-control" required="">
        </div>
    </form>
</div>
<?php
    include ("rodape.php");
?>