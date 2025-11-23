<?php
    require("cabecalho.php");
    require("conexao.php");

    // Buscar usuários e produtos
    try {
        $stmtUsuarios = $pdo->query("SELECT * FROM usuario");
        $usuarios = $stmtUsuarios->fetchAll();

        $stmtProdutos = $pdo->query("
            SELECT p.id_produto, p.descricao_produto, p.valor_produto, p.quantidade_produto, f.nome_fornecedor
            FROM produto p
            INNER JOIN fornecedor f ON p.fornecedor_has_produto_id_fornecedor = f.id_fornecedor
            WHERE p.quantidade_produto > 0
        ");
        $produtos = $stmtProdutos->fetchAll();
    } catch (Exception $e) {
        echo "Erro ao consultar dados: " . $e->getMessage();
    }

    // Se enviou o formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usuario_id = $_POST['usuario'];
        $produtos_selecionados = $_POST['produtos'] ?? [];
        $quantidades = $_POST['quantidades'] ?? [];

        try {
            // Iniciar transação
            $pdo->beginTransaction();

            // Calcular total da venda
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

            // Gerar ID da venda
            $idVenda = time();

            // Inserir venda
            $stmtVenda = $pdo->prepare("
                INSERT INTO vendas (idvendas, total_venda, usuario_id_usuario)
                VALUES (?, ?, ?)
            ");
            $stmtVenda->execute([$idVenda, $total_venda, $usuario_id]);

            // Inserir produtos da venda e atualizar estoque
            foreach($produtos_selecionados as $produto_id) {
                $quantidade = $quantidades[$produto_id];
                
                // Inserir na tabela vendas_has_produto
                $stmtItem = $pdo->prepare("
                    INSERT INTO vendas_has_produto (vendas_idvendas, produto_id_produto)
                    VALUES (?, ?)
                ");
                $stmtItem->execute([$idVenda, $produto_id]);
                
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
            header("Location: vendas.php?cadastro=true");

        } catch (Exception $e) {
            // Rollback em caso de erro
            $pdo->rollBack();
            echo "<div class='alert alert-danger'>Erro ao realizar venda: " . $e->getMessage() . "</div>";
        }
    }
?>

<h1>Nova Venda</h1>

<form method="post" id="formVenda">
    <div class="mb-3">
        <label for="usuario" class="form-label">Selecione o Usuário</label>
        <select id="usuario" name="usuario" class="form-select" required>
            <option value="">Selecione um usuário</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>">
                    <?= $u['nome_usuario'] ?> (<?= $u['email_usuario'] ?>)
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Selecione os Produtos</label>
        
        <?php if(empty($produtos)): ?>
            <div class="alert alert-warning">Nenhum produto disponível em estoque.</div>
        <?php else: ?>
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
                        <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="produtos[]" value="<?= $p['id_produto'] ?>" 
                                       class="form-check-input produto-checkbox" 
                                       onchange="toggleQuantidade(this, <?= $p['id_produto'] ?>)">
                            </td>
                            <td><?= $p['descricao_produto'] ?></td>
                            <td><?= $p['nome_fornecedor'] ?></td>
                            <td>R$ <?= number_format($p['valor_produto'], 2, ',', '.') ?></td>
                            <td><?= $p['quantidade_produto'] ?></td>
                            <td>
                                <input type="number" name="quantidades[<?= $p['id_produto'] ?>]" 
                                       id="quantidade_<?= $p['id_produto'] ?>" 
                                       class="form-control form-control-sm quantidade-input" 
                                       min="1" max="<?= $p['quantidade_produto'] ?>" 
                                       disabled style="width: 80px;">
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>Realizar Venda</button>
        <a href="vendas.php" class="btn btn-secondary">Cancelar</a>
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
</script>

<?php
    require("rodape.php");
?>