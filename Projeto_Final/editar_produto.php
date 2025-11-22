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

/* Buscar fornecedores para o select */
try {
    $stmt = $pdo->query("SELECT * FROM fornecedor");
    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erro ao consultar fornecedores: " . $e->getMessage();
    $fornecedores = [];
}

/* Buscar produto atual (GET) */
$produto = null;
if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM produto WHERE id_produto = ?");
        $stmt->execute([$_GET['id']]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro ao consultar produto: " . $e->getMessage();
    }
} else {
    echo "<p class='text-danger'>ID do produto não informado.</p>";
}

/* Processar POST (edição) */
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $descricao = $_POST['descricao'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 0;
    $fornecedor = $_POST['fornecedor'] ?? null;
    $id_produto = $_POST['id'] ?? null;

    try {

        // Atualiza somente o produto
        $upd = $pdo->prepare("
            UPDATE produto
            SET descricao_produto = ?,
                valor_produto = ?,
                quantidade_produto = ?,
                fornecedor_has_produto_id_fornecedor = ?
            WHERE id_produto = ?
        ");

        if ($upd->execute([
            $descricao,
            $valor,
            $quantidade,
            $fornecedor,
            $id_produto
        ])) {
            redirect("produto.php?editar=true");
        } else {
            redirect("produto.php?editar=false");
        }

    } catch (Exception $e) {
        echo "Erro ao editar: " . $e->getMessage();
    }
}

?>

<h1>Editar Produto</h1>

<?php if ($produto): ?>
<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id_produto']) ?>">

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($produto['descricao_produto']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Informe o valor</label>
        <input value="<?= htmlspecialchars($produto['valor_produto']) ?>" type="number" step="0.01" id="valor" name="valor" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label">Informe a quantidade</label>
        <input value="<?= htmlspecialchars($produto['quantidade_produto']) ?>" type="number" id="quantidade" name="quantidade" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="fornecedor" class="form-label">Selecione o Fornecedor</label>
        <select id="fornecedor" name="fornecedor" class="form-select" required>
            <?php foreach ($fornecedores as $f): ?>
                <option value="<?= $f['id_fornecedor'] ?>"
                    <?= ($f['id_fornecedor'] == $produto['fornecedor_has_produto_id_fornecedor']) ? "selected" : "" ?>>
                    <?= htmlspecialchars($f['nome_fornecedor']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php else: ?>
    <p class="text-warning">Produto não encontrado.</p>
<?php endif; ?>

<?php
require("rodape.php");
?>
