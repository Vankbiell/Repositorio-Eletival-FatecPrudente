<?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $numero = $_POST['numero'];
                $fatorial = $numero;
                for($i=$numero-1;$i>1;$i--){
                    $fatorial = $fatorial * $i;
                    //$fatorial *= $i;
                }
                echo "O fatorial de $numero é: $fatorial";
            }
?>