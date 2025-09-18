<?php
include("cabecalho.php");
    $valor = 5;
    echo"<h1>Tabuada</h1>";
    for($i=1; $i<=10; $i++){
        $resultado = $valor * $i;
        echo"<p>$valor X $i = $resultado</p>";
    }
include ("rodape.php");
?>