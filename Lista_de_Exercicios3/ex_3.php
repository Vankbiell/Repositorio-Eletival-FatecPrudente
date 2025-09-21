<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="palavra1" class="form-label">Informe a primeira palavra </label>
            <input type="text" id="palavra1" name="palavra1" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="palavra2" class="form-label">Informe a segunda palavra </label>
            <input type="text" id="palavra2" name="palavra2" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $palavra1 = $_POST['palavra1'];
    $palavra2 = $_POST['palavra2'];
    if (strpos($palavra1,$palavra2) !== false)
    {
        echo"A segunda palavra ESTÁ contida na primeira";
    }else{
        echo"A segunda palvara NÂO está contida na primeira";
    }
}
include ("rodape.php");
?>