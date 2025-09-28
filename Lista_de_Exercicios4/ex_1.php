<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
    <div class="mb-3">
        <?php for($i=1;$i<=5;$i++): ?>
        <h5>Informe o nome e telefone do seu contato</h5>
        <label for="nome[]" class="form-label">Nome: </label>
        <input type="text" id="nome[]" name="nome[]" class="form-control" required="">
        <label for="numero[]" class="form-label">Número</label>
        <input type="number" id="numero[]" name="numero[]" class="form-control" required="">
        <?php endfor; ?>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vetor_nome = $_POST['nome'];
    $vetor_numero = $_POST['numero'];
    
    // Criar mapa de contatos
    $contatos = array();
    $duplicatas = array();
    
    // Processar cada contato
    for($i=0; $i<count($vetor_nome); $i++){//$i<count($vetor_nome): Continua enquanto $i for menor que a quantidade de elementos no array
        $nome = trim($vetor_nome[$i]); //trim(): Remove espaços em branco do início e fim do texto
        $numero = trim($vetor_numero[$i]);
        
        // Verificar duplicatas
        $tem_duplicata = false;
        
        // Verificar se nome já existe
        if(array_key_exists($nome, $contatos)){
            $duplicatas[] = "Nome duplicado: $nome";
            $tem_duplicata = true;
        }
        
        // Verificar se número já existe
        if(in_array($numero, $contatos)){
            $duplicatas[] = "Número duplicado: $numero";
            $tem_duplicata = true;
        }
        
        // Adicionar ao mapa se não houver duplicata
        if(!$tem_duplicata){
            $contatos[$nome] = $numero;
        }
    }
    
    // Ordenar por nome
    ksort($contatos);
    
    // Exibir duplicatas encontradas
    if(!empty($duplicatas)){
        echo "<div class='alert alert-warning mt-3'><h5>Duplicatas encontradas:</h5>";
        foreach($duplicatas as $dup){
            echo "<p>$dup</p>";
        }
        echo "</div>";
    }
    
    // Exibir lista ordenada
    echo "<div class='mt-3'><h5>Lista de Contatos Ordenada:</h5>";
    if(!empty($contatos)){
        foreach($contatos as $nome => $numero){
            echo "<p><strong>$nome:</strong> $numero</p>";
        }
    } else {
        echo "<p>Nenhum contato válido foi adicionado.</p>";
    }
    echo "</div>";
}

include ("rodape.php");
?>