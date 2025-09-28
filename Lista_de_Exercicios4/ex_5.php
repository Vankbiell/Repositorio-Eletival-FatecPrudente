<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <h2>Controle de Estoque de Livros</h2>
    <form method="post">
        <?php for($i = 1; $i <= 5; $i++): ?>
        <div class="border p-3 mb-3">
            <h5>Livro <?php echo $i; ?></h5>
            
            <div class="mb-2">
                <label for="titulo<?php echo $i; ?>" class="form-label">Título do Livro: </label>
                <input type="text" id="titulo<?php echo $i; ?>" name="titulo[]" class="form-control" required>
            </div>
            
            <div class="mb-2">
                <label for="quantidade<?php echo $i; ?>" class="form-label">Quantidade em Estoque: </label>
                <input type="number" min="0" id="quantidade<?php echo $i; ?>" name="quantidade[]" class="form-control" required>
            </div>
        </div>
        <?php endfor; ?>
        
        <button type="submit" class="btn btn-primary">Verificar Estoque</button>
    </form>
</div>

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulos = $_POST['titulo'];
    $quantidades = $_POST['quantidade'];
    
    // Criar o mapa (título => quantidade)
    $livros_estoque = array();
    
    for($i = 0; $i < count($titulos); $i++){
        $livros_estoque[$titulos[$i]] = intval($quantidades[$i]);
    }
    
    // Ordenar os livros pelo título (alfabeticamente)
    ksort($livros_estoque);
    
    // Exibir resultados
    echo "<div class='container mt-4'>";
    echo "<h3>Lista de Livros Ordenada por Título</h3>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='table-dark'>";
    echo "<tr><th>Título</th><th>Quantidade em Estoque</th><th>Status</th></tr>";
    echo "</thead><tbody>";
    
    $livros_com_baixo_estoque = array();
    
    foreach($livros_estoque as $titulo => $quantidade){
        $status = "";
        $classe_linha = "";
        
        // Verificar se a quantidade é inferior a 5
        if($quantidade < 5){
            $status = "<span class='badge bg-danger'>ESTOQUE BAIXO</span>";
            $classe_linha = "table-warning";
            $livros_com_baixo_estoque[] = $titulo;
        } else if($quantidade >= 5 && $quantidade <= 10){
            $status = "<span class='badge bg-warning text-dark'>ESTOQUE MÉDIO</span>";
        } else {
            $status = "<span class='badge bg-success'>ESTOQUE OK</span>";
        }
        
        echo "<tr class='$classe_linha'>";
        echo "<td><strong>$titulo</strong></td>";
        echo "<td>$quantidade</td>";
        echo "<td>$status</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
    
    // Exibir alerta para livros com baixo estoque
    if(!empty($livros_com_baixo_estoque)){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
        echo "<h4 class='alert-heading'><i class='bi bi-exclamation-triangle'></i> Alerta de Estoque Baixo!</h4>";
        echo "Os seguintes livros estão com estoque inferior a 5 unidades:";
        echo "<ul class='mb-0'>";
        foreach($livros_com_baixo_estoque as $livro){
            echo "<li><strong>$livro</strong></li>";
        }
        echo "</ul>";
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
    }
    
    // Estatísticas do estoque
    $total_livros = count($livros_estoque);
    $total_estoque = array_sum($livros_estoque);
    $media_estoque = $total_estoque / $total_livros;
    
    echo "<div class='row mt-3'>";
    echo "<div class='col-md-4'>";
    echo "<div class='card text-white bg-primary'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>Total de Livros</h5>";
    echo "<p class='card-text display-6'>$total_livros</p>";
    echo "</div></div></div>";
    
    echo "<div class='col-md-4'>";
    echo "<div class='card text-white bg-success'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>Total em Estoque</h5>";
    echo "<p class='card-text display-6'>$total_estoque</p>";
    echo "</div></div></div>";
    
    echo "<div class='col-md-4'>";
    echo "<div class='card text-white bg-info'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>Média por Livro</h5>";
    echo "<p class='card-text display-6'>" . number_format($media_estoque, 1) . "</p>";
    echo "</div></div></div>";
    echo "</div>";
    
    echo "</div>";
}

include("rodape.php");
?>