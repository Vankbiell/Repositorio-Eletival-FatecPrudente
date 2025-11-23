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

// Buscar usuários e produtos disponíveis
try {
    $stmtUsuarios = $pdo->query("SELECT * FROM usuario");
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    $stmtProdutos = $pdo->query("
        SELECT p.id_produto, p.descricao_produto, p.valor_produto, p.quantidade_produto, f.nome_fornecedor
        FROM produto p
        INNER JOIN fornecedor f ON p.fornecedor_has_produto_id_fornecedor = f.id_fornecedor
        WHERE p.quantidade_produto > 0
    ");
    $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erro ao consultar dados: " . $e->getMessage();
    $usuarios = [];
    $produtos = [];
}

/* Buscar venda atual e seus itens */
$venda = null;
$itens_venda = [];

if (isset($_GET['id']) && isset($_GET['usuario_id'])) {
    try {
        // Buscar informações básicas da venda
        $stmt = $pdo->prepare("
            SELECT v.idvendas, v.total_venda, v.usuario_id_usuario, u.nome_usuario
            FROM vendas v
            INNER JOIN usuario u ON v.usuario_id_usuario = u.id_usuario
            WHERE v.idvendas = ? AND v.usuario_id_usuario = ?
        ");
        $stmt->execute([$_GET['id'], $_GET['usuario_id']]);
        $venda = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($venda) {
            // Buscar itens da venda atual
            $stmtItens = $pdo->prepare("
                SELECT 
                    p.id_produto,
                    p.descricao_produto,
                    p.valor_produto,
                    p.quantidade_produto,
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

/* Processar POST (edição) */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario_id = $_POST['usuario'] ?? null;
    $venda_id = $_POST['venda_id'] ?? null;
    $produtos_selecionados = $_POST['produtos'] ?? [];
    $quantidades = $_POST['quantidades'] ?? [];

    try {
        // Iniciar transação
        $pdo->beginTransaction();

        // 1. Restaurar estoque dos produtos antigos
        foreach ($itens_venda as $item_antigo) {
            $stmtRestaurar = $pdo->prepare("
                UPDATE produto 
                SET quantidade_produto = quantidade_produto + 1 
                WHERE id_produto = ?
            ");
            $stmtRestaurar->execute([$item_antigo['id_produto']]);
        }

        // 2. Remover itens antigos da venda
        $stmtRemoverItens = $pdo->prepare("
            DELETE FROM vendas_has_produto 
            WHERE vendas_idvendas = ?
        ");
        $stmtRemoverItens->execute([$venda_id]);

        // 3. Calcular novo total da venda
        $total_venda = 0;
        foreach($produtos_selecionados as $produto_id) {
            $quantidade = $quantidades[$produto_id];
            
            // Buscar valor do produto
            $stmtValor = $pdo->prepare("SELECT valor_produto, quantidade_produto FROM produto WHERE id_produto = ?");
            $stmtValor->execute([$produto_id]);
            $produto = $stmtValor->fetch();
            
            // Verificar estoque
            if($produto['quantidade_produto'] < $quantidade) {
                throw new Exception("Estoque insuficiente para o produto ID: $produto_id");
            }
            
            $total_venda += $produto['valor_produto'] * $quantidade;
        }

        // 4. Atualizar venda com novo total
        $stmtAtualizarVenda = $pdo->prepare("
            UPDATE vendas 
            SET total_venda = ?, usuario_id_usuario = ?
            WHERE idvendas = ?
        ");
        $stmtAtualizarVenda->execute([$total_venda, $usuario_id, $venda_id]);

        // 5. Inserir novos itens da venda e atualizar estoque
        foreach($produtos_selecionados as $produto_id) {
            $quantidade = $quantidades[$produto_id];
            
            // Inserir na tabela vendas_has_produto
            $stmtItem = $pdo->prepare("
                INSERT INTO vendas_has_produto (vendas_idvendas, produto_id_produto)
                VALUES (?, ?)
            ");
            $stmtItem->execute([$venda_id, $produto_id]);
            
            // Atualizar estoque do produto
            $stmtEstoque = $pdo->prepare("
                UPDATE produto 
                SET quantidade_produto = quantidade_produto - ? 
                WHERE id_produto = ?
            ");
            $stmtEstoque->execute([$quantidade, $produto_id]);
        }

        // Commit da transação
        $pdo->commit();
        redirect("vendas.php?editar=true");

    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Erro ao editar venda: " . $e->getMessage() . "</div>";
    }
}

?>

<h1>Editar Venda</h1>

<?php if ($venda): ?>
<form method="post" id="formVenda">
    <input type="hidden" name="venda_id" value="<?= htmlspecialchars($venda['idvendas']) ?>">

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Informações da Venda</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID da Venda:</strong> <?= htmlspecialchars($venda['idvendas']) ?></p>
                    <p><strong>Data/Hora:</strong> <?= date('d/m/Y H:i:s', $venda['idvendas']) ?></p>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário Responsável</label>
                        <select id="usuario" name="usuario" class="form-select" required>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= $u['id_usuario'] ?>"
                                    <?= ($u['id_usuario'] == $venda['usuario_id_usuario']) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($u['nome_usuario']) ?> (<?= $u['email_usuario'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Produtos da Venda</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($produtos)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Selecionar</th>
                                <th>Produto</th>
                                <th>Fornecedor</th>
                                <th>Valor Unitário</th>
                                <th>Estoque</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $produtos_selecionados_ids = array_column($itens_venda, 'id_produto');
                            foreach ($produtos as $p): 
                                $esta_selecionado = in_array($p['id_produto'], $produtos_selecionados_ids);
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="produtos[]" value="<?= $p['id_produto'] ?>" 
                                           class="form-check-input produto-checkbox" 
                                           onchange="toggleQuantidade(this, <?= $p['id_produto'] ?>)"
                                           <?= $esta_selecionado ? 'checked' : '' ?>>
                                </td>
                                <td><?= htmlspecialchars($p['descricao_produto']) ?></td>
                                <td><?= htmlspecialchars($p['nome_fornecedor']) ?></td>
                                <td>R$ <?= number_format($p['valor_produto'], 2, ',', '.') ?></td>
                                <td><?= $p['quantidade_produto'] ?></td>
                                <td>
                                    <input type="number" name="quantidades[<?= $p['id_produto'] ?>]" 
                                           id="quantidade_<?= $p['id_produto'] ?>" 
                                           class="form-control form-control-sm quantidade-input" 
                                           min="1" max="<?= $p['quantidade_produto'] ?>" 
                                           value="<?= $esta_selecionado ? '1' : '' ?>"
                                           <?= $esta_selecionado ? '' : 'disabled' ?> 
                                           style="width: 80px;">
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Nenhum produto disponível em estoque.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="btnSubmit">Atualizar Venda</button>
        <a href="vendas.php" class="btn btn-secondary">Cancelar</a>
        <a href="consultar_venda.php?id=<?= $venda['idvendas'] ?>&usuario_id=<?= $venda['usuario_id_usuario'] ?>" class="btn btn-info">Consultar Venda</a>
    </div>
</form>

<script>
function toggleQuantidade(checkbox, produtoId) {
    const quantidadeInput = document.getElementById('quantidade_' + produtoId);
    quantidadeInput.disabled = !checkbox.checked;
    if (!checkbox.checked) {
        quantidadeInput.value = '';
    }
    validarFormulario();
}

function validarFormulario() {
    const usuarioSelecionado = document.getElementById('usuario').value;
    const produtosSelecionados = document.querySelectorAll('.produto-checkbox:checked');
    const btnSubmit = document.getElementById('btnSubmit');
    
    // Verificar se há pelo menos um produto selecionado com quantidade válida
    let quantidadeValida = false;
    produtosSelecionados.forEach(checkbox => {
        const produtoId = checkbox.value;
        const quantidadeInput = document.getElementById('quantidade_' + produtoId);
        if (quantidadeInput.value && quantidadeInput.value > 0) {
            quantidadeValida = true;
        }
    });
    
    btnSubmit.disabled = !(usuarioSelecionado && produtosSelecionados.length > 0 && quantidadeValida);
}

// Adicionar event listeners
document.querySelectorAll('.quantidade-input').forEach(input => {
    input.addEventListener('input', validarFormulario);
});

document.getElementById('usuario').addEventListener('change', validarFormulario);

// Inicializar validação
validarFormulario();
</script>

<?php else: ?>
    <div class="alert alert-warning">
        Venda não encontrada.
    </div>
    <a href="vendas.php" class="btn btn-secondary">Voltar para Vendas</a>
<?php endif; ?>

<?php
require("rodape.php");
?>