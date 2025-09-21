<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
        <div class="mb-3">
            <label for="dia" class="form-label">Informe o dia </label>
            <input type="number" id="dia" name="dia" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="mes" class="form-label">Informe o mês </label>
            <input type="number" id="mes" name="mes" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="ano" class="form-label">Informe o ano </label>
            <input type="number" id="ano" name="ano" class="form-control" required="">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
    if (checkdate($mes, $dia, $ano)) {
    // Converte para timestamp e formata com date()
    $timestamp = mktime(0, 0, 0, $mes, $dia, $ano);
    $dataFormatada = date("d/m/Y", $timestamp);
    
    echo "Data válida: $dataFormatada";
    } else {
        echo "Data inválida!";
    }
}
include ("rodape.php");
?>