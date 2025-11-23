<?php
require("cabecalho.php");
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Verifica se id foi passado
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<p class='text-danger'>ID do produto não informado.</p>";
        require("rodape.php");
        exit;
    }

    try {
        // Busca o produto com os campos e as FKs
        $stmt = $pdo->prepare("
            SELECT p.*,
                   fhp.id_prod_forn AS id_prod_forn,
                   fhp.fornecedor_id_fornecedor AS id_fornecedor
            FROM produto p
            LEFT JOIN fornecedor_has_produto fhp
              ON fhp.id_prod_forn = p.fornecedor_has_produto_id_prod_forn
             AND fhp.fornecedor_id_fornecedor = p.fornecedor_has_produto_id_fornecedor
            WHERE p.id_produto = ?
        ");
        $stmt->execute([$_GET['id']]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            echo "<p class='text-danger'>Produto não encontrado.</p>";
            require("rodape.php");
            exit;
        }

        // Buscar nome do fornecedor (se houver)
        $nome_fornecedor = null;
        if (!empty($produto['id_fornecedor'])) {
            $stmt2 = $pdo->prepare("SELECT nome_fornecedor FROM fornecedor WHERE id_fornecedor = ?");
            $stmt2->execute([$produto['id_fornecedor']]);
            $f = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($f) $nome_fornecedor = $f['nome_fornecedor'];
        }
    } catch (Exception $e) {
        echo "Erro ao consultar produto: " . $e->getMessage();
        require("rodape.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Exclusão do produto
    $id = $_POST['id'] ?? null;
    if (!$id) {
        echo "<p class='text-danger'>ID inválido para exclusão.</p>";
        require("rodape.php");
        exit;
    }

    try {
        // Começa transação
        $pdo->beginTransaction();

        // Busca chaves para excluir associação se necessário
        $stmt = $pdo->prepare("
            SELECT fornecedor_has_produto_id_prod_forn, fornecedor_has_produto_id_fornecedor
            FROM produto
            WHERE id_produto = ?
            FOR UPDATE
        ");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$p) {
            // produto já não existe
            $pdo->rollBack();
            header('Location: produtos.php?excluir=false');
            exit;
        }

        $idProdForn = $p['fornecedor_has_produto_id_prod_forn'];
        $idFornecedor = $p['fornecedor_has_produto_id_fornecedor'];

        // Deleta o produto
        $delProd = $pdo->prepare("DELETE FROM produto WHERE id_produto = ?");
        $ok1 = $delProd->execute([$id]);

        $ok2 = true;
        // Tenta deletar a associação fornecedor_has_produto apenas se os ids existirem
        if (!empty($idProdForn) && !empty($idFornecedor)) {
            // Verifica se essa associação está ligada a outro produto
            $check = $pdo->prepare("
                SELECT COUNT(*) as cnt FROM produto
                WHERE fornecedor_has_produto_id_prod_forn = ? 
                  AND fornecedor_has_produto_id_fornecedor = ?
            ");
            $check->execute([$idProdForn, $idFornecedor]);
            $cnt = $check->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;

            // se cnt == 0 (nenhum outro produto usando), podemos remover a associação
            if ($cnt == 0) {
                $delAssoc = $pdo->prepare("
                    DELETE FROM fornecedor_has_produto
                    WHERE id_prod_forn = ? AND fornecedor_id_fornecedor = ?
                ");
                $ok2 = $delAssoc->execute([$idProdForn, $idFornecedor]);
            }
        }

        if ($ok1 && $ok2) {
            $pdo->commit();
            header('Location: produto.php?excluir=true');
            exit;
        } else {
            $pdo->rollBack();
            header('Location: produto.php?excluir=false');
            exit;
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo "Erro ao excluir produto: " . $e->getMessage();
        require("rodape.php");
        exit;
    }
}
?>

<h1>Consultar Produto</h1>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id_produto'] ?? '') ?>">

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea id="descricao" class="form-control" rows="4" disabled><?= htmlspecialchars($produto['descricao_produto'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input id="valor" class="form-control" type="text" disabled value="<?= htmlspecialchars(isset($produto['valor_produto']) ? number_format($produto['valor_produto'], 2, ',', '.') : '') ?>">
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label">Quantidade:</label>
        <input id="quantidade" class="form-control" type="text" disabled value="<?= htmlspecialchars($produto['quantidade_produto'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="fornecedor" class="form-label">Fornecedor:</label>
        <input id="fornecedor" class="form-control" type="text" disabled value="<?= htmlspecialchars($nome_fornecedor ?? '—') ?>">
    </div>

    <p>Deseja excluir esse registro?</p>

    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">Voltar</button>
</form>

<?php require("rodape.php"); ?>
