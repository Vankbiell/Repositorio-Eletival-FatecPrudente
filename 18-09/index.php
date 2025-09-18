<?php

    $valor = array(1, 2, 3, 4, 5);
    echo "<P>Primeiro valor do vetor: ".$valor[0]."</p>";
    // $v = $_POST['nome'];

    $vetor = [1, 2, 3, 4, 5];

    var_dump($vetor);
    echo"<br/>";
    print_r($vetor);

    $vetor[4] = 6;
    echo "<p> Novo valor da posição 4: ".$vetor[4]."</p>";

    $vetor['nome'] = "Vanessa";
    print_r($vetor);

    $valores = [
        'nome' => "Vanessa",
        "sobrenome" => 'Borges',
        'idade' => 35
    ];
    foreach ($valores as $c => $v){
        echo "<p>Posição: $c = Valor $v </p>";
    }