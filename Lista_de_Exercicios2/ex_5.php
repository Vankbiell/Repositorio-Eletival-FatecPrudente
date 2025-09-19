<?php
include("cabecalho.php");
    $numero = 2;
        switch($numero){
            case 1:
                echo "<p>Janeiro</p>";
                break;
            case 2:
                echo "<p>Fevereiro</p>";
                break;
            case 3:
                echo "<p>Março</p>";
                break;
            case 4:
                echo "<p>Abril</p>";
                break;
                //Adicionar outros meses
            default:
                 echo "<p>Número não possui mês correspondente!</p>";
    }
?>