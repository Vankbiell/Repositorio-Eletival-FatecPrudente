<?php
include("cabecalho.php");
    $numero = 5;
    $fatorial = $numero;
    for($i=$numero-1;$i>1;$i--){
        $fatorial = $fatorial * $i;
        //$fatorial *= $i;
    }
    echo "O fatorial de $numero é: $fatorial";
include ("rodape.php");
?>