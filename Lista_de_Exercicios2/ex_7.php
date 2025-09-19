<?php
include("cabecalho.php");
    $valor = 10;
    $total = 0;
    $i = 1;
    while($i <= $valor){
        $total += $i;
        $i++;
    }
    echo "<p>Total: $total</p>";
?>