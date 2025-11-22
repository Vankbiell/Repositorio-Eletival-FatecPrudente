<?php
    require("cabecalho.php");
    require("conexao.php");

    // Buscar fornecedores
    try {
        $stmt = $pdo->query("SELECT * FROM fornecedor");
        $fornecedores = $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Erro ao consultar fornecedores: " . $e->getMessage();
    }

    // Se enviou o formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $fornecedor = $_POST['fornecedor'];

        try {

            // O banco exige também o ID do fornecedor_has_produto
            // Como ele não é autoincrement, vamos inserir 1 novo registro
            // para cada produto inserido
            $stmt = $pdo->prepare("
                INSERT INTO fornecedor_has_produto (id_prod_forn, fornecedor_id_fornecedor)
                VALUES (?, ?)
            ");

            // Gerar ID dynamicamente:
            $idProdForn = time(); // simples e único

            $stmt->execute([$idProdForn, $fornecedor]);

            // Agora inserir produto
            $stmt2 = $pdo->prepare("
                INSERT INTO produto
                (descricao_produto, valor_produto, quantidade_produto,
                 fornecedor_has_produto_id_prod_forn,
                 fornecedor_has_produto_id_fornecedor)
                VALUES (?, ?, ?, ?, ?)
            ");

            if ($stmt2->execute([
                $descricao,
                $valor,
                0,                // quantidade padrão
                $idProdForn,
                $fornecedor
            ])) {
                header("Location: produto.php?cadastro=true");
            } else {
                header("Location: produto.php?cadastro=false");
            }

        } catch (Exception $e) {
            echo "Erro ao inserir: " . $e->getMessage();
        }
    }
?>

<h1>Novo Produto</h1>

<form method="post">
    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a descrição:</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Informe o Valor</label>
        <input type="number" id="valor" step="0.01" name="valor" class="form-control">
    </div>

    <div class="mb-3">
        <label for="fornecedor" class="form-label">Selecione o Fornecedor</label>
        <select id="fornecedor" name="fornecedor" class="form-select">
            <?php foreach ($fornecedores as $f): ?>
                <option value="<?= $f['id_fornecedor'] ?>">
                    <?= $f['nome_fornecedor'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    require("rodape.php");
?>
