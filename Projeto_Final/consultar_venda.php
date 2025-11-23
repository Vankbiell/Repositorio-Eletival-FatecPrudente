<?php
require("cabecalho.php");
require("conexao.php");

/**
 * Função de redirect com fallback JS
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

/* Buscar dados da venda */
$venda = null;
$itens_venda = [];

if (isset($_GET['id']) && isset($_GET['usuario_id'])) {
    try {
        // Buscar informações básicas da venda
        $stmt = $pdo->prepare("
            SELECT v.idvendas, v.total_venda, v.usuario_id_usuario, u.nome_usuario, u.email_usuario
            FROM vendas v
            INNER JOIN usuario u ON v.usuario_id_usuario = u.id_usuario
            WHERE v.idvendas = ? AND v.usuario_id_usuario = ?
        ");
        $stmt->execute([$_GET['id'], $_GET['usuario_id']]);
        $venda = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($venda) {
            // Buscar itens da venda
            $stmtItens = $pdo->prepare("
                SELECT 
                    p.id_produto,
                    p.descricao_produto,
                    p.valor_produto,
                    f.nome_fornecedor
                FROM vendas_has_produto vp
                INNER JOIN produto p ON vp.produto_id_produto = p.id_produto
                INNER JOIN fornecedor f ON p.fornecedor_has_produto_id_fornecedor = f.id_fornecedor
                WHERE vp.vendas_idvendas = ?
            ");
            $stmtItens->execute([$_GET['id']]);
            $itens_venda = $stmtItens->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro ao consultar venda: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<p class='text-danger'>ID da venda não informado.</p>";
}

?>

<h1>Consultar Venda</h1>

<?php if ($venda): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Informações da Venda</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID da Venda:</strong> <?= htmlspecialchars($venda['idvendas']) ?></p>
                    <p><strong>Data/Hora:</strong> <?= date('d/m/Y H:i:s', $venda['idvendas']) ?></p>
                    <p><strong>Total da Venda:</strong> R$ <?= number_format($venda['total_venda'], 2, ',', '.') ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Usuário:</strong> <?= htmlspecialchars($venda['nome_usuario']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($venda['email_usuario']) ?></p>
                    <p><strong>ID do Usuário:</strong> <?= htmlspecialchars($venda['usuario_id_usuario']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Produtos da Venda</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($itens_venda)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Produto</th>
                                <th>Descrição</th>
                                <th>Fornecedor</th>
                                <th>Valor Unitário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens_venda as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id_produto']) ?></td>
                                <td><?= htmlspecialchars($item['descricao_produto']) ?></td>
                                <td><?= htmlspecialchars($item['nome_fornecedor']) ?></td>
                                <td>R$ <?= number_format($item['valor_produto'], 2, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>R$ <?= number_format($venda['total_venda'], 2, ',', '.') ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Nenhum produto encontrado para esta venda.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-3">
        <a href="vendas.php" class="btn btn-secondary">Voltar para Vendas</a>
    </div>

<?php else: ?>
    <div class="alert alert-warning">
        Venda não encontrada.
    </div>
    <a href="vendas.php" class="btn btn-secondary">Voltar para Vendas</a>
<?php endif; ?>

<?php
require("rodape.php");
?>