<?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          $valor1 = $_POST['valor1'];
          $valor2 = $_POST['valor2'];
          $valor3 = $_POST['valor3'];
          $valor4 = $_POST['valor4'];
          $valor5 = $_POST['valor5'];
          $valor6 = $_POST['valor6'];

          $menor = $valor1;
          $posicao = 1;

          if($valor2 < $menor){
            $menor = $valor2;
            $posicao = 2;
          }

          if($valor3 < $menor){
            $menor = $valor3;
            $posicao = 3;
          }

          if($valor4 < $menor){
            $menor = $valor4;
            $posicao = 4;
          }

          if($valor5 < $menor){
            $menor = $valor5;
            $posicao = 5;
          }

          if($valor6 < $menor){
            $menor = $valor6;
            $posicao = 6;
          }

          if($valor7 < $menor){
            $menor = $valor7;
            $posicao = 7;
          }

          echo "<p> O menor valor informado é: $menor e está na posição $posicao";

        }
?>