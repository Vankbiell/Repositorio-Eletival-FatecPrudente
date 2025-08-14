<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>primeiro Exemplo</title>
</head>
<body>
    <?php
    
        $dia = date("d");
        $mes = date("m");
        $ano = date("y");
    ?>
    <h1>Hoje é dia <?=$dia?> de <!--<?=$mes?>-->Agosto de <?=$ano?></h1>

</body>
</html>