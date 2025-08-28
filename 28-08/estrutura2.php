<?php 
    include("cabecalho.php");
    $valor  = 11;
    if($valor > 10 )
        echo "valor maior que  10";
    elseif($valor < 10){
        echo"Valor menor que 10";
    }
    else {
        echo "Valor igual da 10";
    }

    include("rodape.php");