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

    $dia = (int)$dia;
    $mes = (int)$mes;
    $ano = (int)$ano;

    if (checkdate($mes, $dia, $ano)) {
        $data = DateTime::createFromFormat('Y-m-d', "$ano-$mes-$dia");
        $dataFormatada = $data->format('d/m/Y');
        $mensagem = "<div class='sucesso'>Data válida: <strong>$dataFormatada</strong></div>";
    } else {
        $mensagem = "<div class='erro'>Data inválida! Por favor, verifique os valores.</div>";
    }
} else {
    $mensagem = "<div class='info'>Informe uma data para validar</div>";
}
include ("rodape.php");
?>