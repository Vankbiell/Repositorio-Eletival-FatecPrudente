<?php
require("cabecalho.php");
require("conexao.php");

/**
 * Função de redirect com fallback JS (caso headers já tenham sido enviados)
 */
function redirect($url){
    if (!headers_sent()) {
        header("Location: $url");
        exit;
    } else {
        echo "<script>location.href='$url'</script>";
        exit;
    }
}

// Verificar se os parâmetros necessários foram passados
if (isset($_GET['id']) && isset($_GET['usuario_id'])) {
    $venda_id = $_GET['id'];
    $usuario_id = $_GET['usuario_id'];
    
    try {
        // Iniciar transação para garantir consistência
        $pdo->beginTransaction();

        // 1. Buscar os produtos da venda para restaurar o estoque
        $stmtItens = $pdo->prepare("
            SELECT vp.produto_id_produto 
            FROM vendas_has_produto vp 
            WHERE vp.vendas_idvendas = ?
        ");
        $stmtItens->execute([$venda_id]);
        $itens_venda = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        // 2. Restaurar o estoque dos produtos
        foreach ($itens_venda as $item) {
            $stmtRestaurarEstoque = $pdo->prepare("
                UPDATE produto 
                SET quantidade_produto = quantidade_produto + 1 
                WHERE id_produto = ?
            ");
            $stmtRestaurarEstoque->execute([$item['produto_id_produto']]);
        }

        // 3. Excluir os itens da venda (vendas_has_produto)
        $stmtExcluirItens = $pdo->prepare("
            DELETE FROM vendas_has_produto 
            WHERE vendas_idvendas = ?
        ");
        $stmtExcluirItens->execute([$venda_id]);

        // 4. Excluir a venda
        $stmtExcluirVenda = $pdo->prepare("
            DELETE FROM vendas 
            WHERE idvendas = ? AND usuario_id_usuario = ?
        ");
        $stmtExcluirVenda->execute([$venda_id, $usuario_id]);

        // Commit da transação
        $pdo->commit();
        
        // Redirecionar com mensagem de sucesso
        redirect("vendas.php?excluir=true");

    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Erro ao excluir venda: " . $e->getMessage() . "</div>";
        echo "<a href='vendas.php' class='btn btn-secondary mt-3'>Voltar para Vendas</a>";
    }
} else {
    echo "<div class='alert alert-danger'>ID da venda ou usuário não informado.</div>";
    echo "<a href='vendas.php' class='btn btn-secondary mt-3'>Voltar para Vendas</a>";
}

require("rodape.php");
?>