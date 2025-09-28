<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <h2>Cadastro de Produtos</h2>
    <form method="post">
        <?php for($i = 1; $i <= 5; $i++): ?>
        <div class="border p-3 mb-3">
            <h5>Produto <?php echo $i; ?></h5>
            
            <div class="mb-2">
                <label for="codigo<?php echo $i; ?>" class="form-label">Código: </label>
                <input type="text" id="codigo<?php echo $i; ?>" name="codigo[]" class="form-control" required>
            </div>
            
            <div class="mb-2">
                <label for="nome<?php echo $i; ?>" class="form-label">Nome: </label>
                <input type="text" id="nome<?php echo $i; ?>" name="nome[]" class="form-control" required>
            </div>
            
            <div class="mb-2">
                <label for="preco<?php echo $i; ?>" class="form-label">Preço (R$): </label>
                <input type="number" step="0.01" min="0" id="preco<?php echo $i; ?>" name="preco[]" class="form-control" required>
            </div>
        </div>
        <?php endfor; ?>
        
        <button type="submit" class="btn btn-primary">Processar Produtos</button>
    </form>
</div>

<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $codigos = $_POST['codigo'];
    $nomes = $_POST['nome'];
    $precos = $_POST['preco'];
    
    // Criar o mapa principal (código => array com nome e preço)
    $produtos = array();
    
    for($i = 0; $i < count($codigos); $i++){
        $preco_original = floatval($precos[$i]);
        $preco_final = $preco_original;
        
        // Aplicar 10% de desconto se preço > R$ 100,00
        if($preco_original > 100.00){
            $desconto = $preco_original * 0.10;
            $preco_final = $preco_original - $desconto;
        }
        
        // Criar mapa interno para cada produto
        $produtos[$codigos[$i]] = array(
            'nome' => $nomes[$i],
            'preco_original' => $preco_original,
            'preco_final' => $preco_final,
            'desconto_aplicado' => ($preco_original > 100.00)
        );
    }
    
    // Ordenar os produtos pelo nome
    uasort($produtos, function($a, $b) {
        return strcmp($a['nome'], $b['nome']);
    });
    
    // Exibir resultados
    echo "<div class='container mt-4'>";
    echo "<h3>Lista de Produtos Ordenada por Nome</h3>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='table-dark'>";
    echo "<tr><th>Código</th><th>Nome</th><th>Preço Original</th><th>Preço com Desconto</th><th>Desconto</th></tr>";
    echo "</thead><tbody>";
    
    foreach($produtos as $codigo => $dados_produto){
        $desconto_texto = $dados_produto['desconto_aplicado'] ? 
                         "<span class='text-success'>10% aplicado</span>" : 
                         "<span class='text-muted'>Sem desconto</span>";
        
        echo "<tr>";
        echo "<td><strong>$codigo</strong></td>";
        echo "<td>{$dados_produto['nome']}</td>";
        echo "<td>R$ " . number_format($dados_produto['preco_original'], 2, ',', '.') . "</td>";
        echo "<td>R$ " . number_format($dados_produto['preco_final'], 2, ',', '.') . "</td>";
        echo "<td>$desconto_texto</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
    echo "</div>";
}

include("rodape.php");
?>