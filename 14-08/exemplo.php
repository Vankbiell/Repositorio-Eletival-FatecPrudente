<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>primeiro Exemplo</title>
</head>
<body>
    <?php
    // https://vanessaborges2.github.io/Gerador-Formulario/
    //como executar o código: php -S localhost:8080
        $dia = date("d"); //como declarar uma variável
        $mes = date("m");
        $ano = date("y");

        echo "<p>" . $dia . "</p>"; 
    ?>
    <h1>Hoje é dia <?=$dia?> de <!--<?=$mes?>-->Agosto de <?=$ano?></h1>    


</body>
</html>