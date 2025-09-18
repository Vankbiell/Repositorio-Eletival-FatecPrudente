<?php
include("cabecalho.php");
    $valor = 10;
    $i = 1;
    do{
        echo"<p> Número $valor</p>";
        $valor -= 1;
        $i++;
    }while($valor);
include ("rodape.php");
?>