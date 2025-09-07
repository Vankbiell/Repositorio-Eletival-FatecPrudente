<?php
include("cabecalho.php");
    $valor = 50 ;
    if ($valor > 100){
        $valor -= ($valor * (15 / 100));
        echo" <p>O valor do produto é maior que 100 reais então é aplicado o desconto de 15%</p>";
        echo" <p>O valor do produto como o desconto aplicado é $valor </p>";
    }
    else{
        echo "<p>O valor nâo tem desconto</p>";
        echo "<p> O valor é $valor</p>";
    }

include ("rodape.php");
?>