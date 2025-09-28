<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <h2>Cadastro de Itens</h2>
    <form method="post">
        <?php for($i = 1; $i <= 5; $i++): ?>
        <div class="border p-3 mb-3">
            <h5>Item <?php echo $i; ?></h5>
            
            <div class="mb-2">
                <label for="nome<?php echo $i; ?>" class="form-label">Nome do Item: </label>
                <input type="text" id="nome<?php echo $i; ?>" name="nome[]" class="form-control" required>
            </div>
            
            <div class="mb-2">
                <label for="preco<?php echo $i; ?>" class="form-label">Preço (R$): </label>
                <input type="number" step="0.01" min="0" id="preco<?php echo $i; ?>" name="preco[]" class="form-control" required>
            </div>
        </div>
        <?php endfor; ?>
        
        <button type="submit" class="btn btn-primary">Calcular com Imposto</button>
    </form>
</div>

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nomes = $_POST['nome'];
    $precos = $_POST['preco'];
    
    // Criar o mapa (nome => preço com imposto)
    $itens_com_imposto = array();
    
    for($i = 0; $i < count($nomes); $i++){
        $preco_original = floatval($precos[$i]);
        
        // Aplicar imposto de 15%
        $imposto = $preco_original * 0.15;
        $preco_com_imposto = $preco_original + $imposto;
        
        // Adicionar ao mapa
        $itens_com_imposto[$nomes[$i]] = $preco_com_imposto;
    }
    
    // Ordenar os itens pelo preço com imposto (do menor para o maior)
    asort($itens_com_imposto);
    
    // Exibir resultados
    echo "<div class='container mt-4'>";
    echo "<h3>Lista de Itens Ordenada por Preço com Imposto (15%)</h3>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='table-dark'>";
    echo "<tr><th>Item</th><th>Preço Original</th><th>Preço com Imposto</th><th>Valor do Imposto</th></tr>";
    echo "</thead><tbody>";
    
    foreach($itens_com_imposto as $nome => $preco_final){
        // Encontrar o preço original correspondente
        $index = array_search($nome, $nomes);
        $preco_original = floatval($precos[$index]);
        $valor_imposto = $preco_final - $preco_original;
        
        echo "<tr>";
        echo "<td><strong>$nome</strong></td>";
        echo "<td>R$ " . number_format($preco_original, 2, ',', '.') . "</td>";
        echo "<td class='fw-bold'>R$ " . number_format($preco_final, 2, ',', '.') . "</td>";
        echo "<td class='text-danger'>R$ " . number_format($valor_imposto, 2, ',', '.') . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
    echo "</div>";
}

include("rodape.php");
?>