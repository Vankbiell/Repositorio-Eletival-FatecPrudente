<?php
include("cabecalho.php");
    $valor1 = 5;
    $valor2 = 8;
    $valor3 = 2;
    $valor4 = 20;
    $valor5 = 1;
    $valor6 = 90;

    $menor = $valor1;
    $posicao = 1;

    if($valor2 < $menor){
        $menor = $valor2;
        $posicao = 2;
    }

    if($valor3 < $menor){
        $menor = $valor3;
        $posicao = 3;
    }

    if($valor4 < $menor){
        $menor = $valor4;
        $posicao = 4;
    }

    if($valor5 < $menor){
        $menor = $valor5;
        $posicao = 5;
    }

    if($valor6 < $menor){
            $menor = $valor6;
            $posicao = 6;
    }

    if($valor7 < $menor){
            $menor = $valor7;
            $posicao = 7;
    }

    echo "<p> O menor valor informado é: $menor e está na posição $posicao";

include ("rodape.php");
?>
