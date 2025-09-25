<?php

    $dominio = "mysql:host=localhost;dbname:projetophp";//definição da string de conexão
    $usuario = "root";
    $senha = "";
    try {
        $pdo = new PDO($dominio, $usuario, $senha);
    } catch(Exception $e) {
        die();
    }


