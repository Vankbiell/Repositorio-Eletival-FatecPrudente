<?php
    $nome = "Gabriel";
    echo "<p>Todas em maiúsculo:".strtoupper($nome)."</p>";
    echo "<p>Todas em maiúsculo:".strtolower($nome)."</p>";
    echo"<p>Quantidade de caracteres:".strlen($nome)."</p>";
    $posicao = strpos($nome,"e");
    echo"<p>Caractere e na posição $posicao</p>";
    date_default_timezone_set("America/Sao_Paulo");
    $data1 = date("d/m/Y");
    $dia = date("d");
    $hora = date("H:i:s");
    echo"<p>Data: $data1</p>";
    echo"<p>Dia</p>";
    echo"<p></p>";






    $valor = -10;
    echo"<p>Valor absoluto".abs($valor)."</p>";
    $valor = 5.9;
    echo"<p>Valor arredondado".round($valor)."</p>";
    $valor = round(1,100);
    echo"<p>Valor aléatorio: $valor</p>";
    echo"<p>Raiz quadrada de 16:".sqtr(16)."</p>";
    $valor = 13.5;
    echo"<p>valor Formatado: R$".
                number_format($valor,2,",",".")."</p>";


    function