<?php
include("cabecalho.php");
    
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o número para receber uma lista do número informado até o 1 </label>
            <input type="number" id="valor" name="valor" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $valor = $_POST['valor'];
    $i = 1;
    do{
        echo"<p> Número $valor</p>";
        $valor -= 1;
        $i++;
    }while($valor);
}
include("rodape.php");
?>