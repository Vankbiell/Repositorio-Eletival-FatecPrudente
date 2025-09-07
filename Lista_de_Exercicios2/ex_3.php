<?php
include("cabecalho.php");
    $numero1 = 3;
    $numero2 = 3;

    if ($numero1 == $numero2)
        echo "Os valores sâo iguais: $numero1";
    elseif ($numero1 > $numero2)
        echo " O valor A é o maior $numero1,$numero2";
    else
        echo " O valor B é o maior $numero2,$numero1";

include ("rodape.php");
?>