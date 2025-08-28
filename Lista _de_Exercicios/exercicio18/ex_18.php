<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $capital = $_POST['capital'];
    $taxa = $_POST['taxa'];
    $periodo = $_POST['periodo'];
    $juros = $capital * (1 + $taxa) ** $periodo;
    echo "O valor do juros é: $juros";
}
?>