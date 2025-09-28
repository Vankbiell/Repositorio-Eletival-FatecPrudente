<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
    <div class="mb-3">
        <?php for($i=1;$i<=5;$i++): ?>
        <div class="border p-3 mb-3">
            <h5>Aluno <?php echo $i; ?></h5>
            <label for="nome<?php echo $i; ?>" class="form-label">Nome: </label>
            <input type="text" id="nome<?php echo $i; ?>" name="nome[]" class="form-control" required>
            
            <label class="form-label mt-2">Notas: </label>
            <input type="number" step="any" name="nota1[]" class="form-control mb-2" placeholder="Nota 1" required>
            <input type="number" step="any" name="nota2[]" class="form-control mb-2" placeholder="Nota 2" required>
            <input type="number" step="any" name="nota3[]" class="form-control mb-2" placeholder="Nota 3" required>
        </div>
        <?php endfor; ?>
    </div>
    <button type="submit" class="btn btn-primary">Calcular Médias</button>
    </form>
</div>
<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vetor_nome = $_POST['nome'];
    $vetor_nota1 = $_POST['nota1'];
    $vetor_nota2 = $_POST['nota2'];
    $vetor_nota3 = $_POST['nota3'];
    
    // Criar o mapa (array associativo) com nomes como chaves e médias como valores
    $alunos_medias = array();
    
    for($i = 0; $i < count($vetor_nome); $i++){
        $media = ($vetor_nota1[$i] + $vetor_nota2[$i] + $vetor_nota3[$i]) / 3;
        $alunos_medias[$vetor_nome[$i]] = $media;
    }
    
    // Ordenar o mapa pelas médias (do maior para o menor)
    arsort($alunos_medias); //arsort() ordena um array associativo pelos valores em ordem decrescente, mantendo a associação chave-valor
    
    // Exibir lista ordenada
    echo "<div class='container mt-4'><h5>Lista de Alunos Ordenada por Média (Maior para Menor):</h5>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Aluno</th><th>Média</th></tr></thead><tbody>";
    
    foreach($alunos_medias as $nome => $media){
        echo "<tr><td><strong>$nome</strong></td><td>" . number_format($media, 2) . "</td></tr>";//number_format($media, 2) formata a média com 2 casas decimais
    }
    
    echo "</tbody></table></div>";
}

include ("rodape.php");
?>