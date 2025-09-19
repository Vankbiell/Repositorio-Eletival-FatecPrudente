<?php
include("cabecalho.php");
    $valor1 = 2;
    $valor2 = 2;
    if ($valor1 == $valor2){
        $soma = $valor1 + $valor2;
        $triplo = $soma * 3;
        echo "Os dois valores são iguais então o tiplo da soma é: $triplo";
    }
    else{
        $soma = $valor1 + $valor2;
        echo"A soma dos dois números é: $soma";
    }
?>