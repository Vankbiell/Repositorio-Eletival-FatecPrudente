<?php 
    include("cabecalho.php");
    $valor  = 10;
    if($valor > 10 )
        echo "valor amior que  10";
    elseif($valor < 10){
        echo"Valor menor que 10";
    }
    else {
        echo "Valor igual da 10";
    }

    include("rodape.php");