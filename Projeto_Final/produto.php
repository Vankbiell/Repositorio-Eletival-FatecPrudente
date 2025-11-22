<?php
    require("cabecalho.php");
    require("conexao.php");

    try{
        // JOIN ajustado para o seu banco
        $stmt = $pdo->query("
            SELECT f.nome_fornecedor AS nome_fornecedor, p.*
            FROM produto p
            INNER JOIN fornecedor f 
                ON f.id_fornecedor = p.fornecedor_has_produto_id_fornecedor
        ");
        $dados = $stmt->fetchAll();
    } catch(\Exception $e){
        echo "Erro: ".$e->getMessage();
    }

    // Mensagens de retorno
    if (isset($_GET['cadastro']) && $_GET['cadastro']){
        echo "<p class='text-success'>Cadastro realizado!</p>";
    } else if (isset($_GET['cadastro']) && !$_GET['cadastro']){
        echo "<p class='text-danger'>Erro ao cadastrar!</p>";
    }
    if (isset($_GET['editar']) && $_GET['editar']){
        echo "<p class='text-success'>Registro editado!</p>";
    } else if (isset($_GET['editar']) && !$_GET['editar']){
        echo "<p class='text-danger'>Erro ao editar!</p>";
    }
    if (isset($_GET['excluir']) && $_GET['excluir']){
        echo "<p class='text-success'>Registro excluído!</p>";
    } else if (isset($_GET['excluir']) && !$_GET['excluir']){
        echo "<p class='text-danger'>Erro ao excluir!</p>";
    }
?>

<h2>Produtos</h2>
<a href="novo_produto.php" class="btn btn-success mb-3">Novo Registro</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Fornecedor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dados as $d): ?>
        <tr>
            <td><?= $d['id_produto'] ?></td>
            <td><?= $d['descricao_produto'] ?></td>
            <td><?= $d['nome_fornecedor'] ?></td>
            <td class="d-flex gap-2">
                <a href="editar_produto.php?id=<?= $d['id_produto'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="consultar_produto.php?id=<?= $d['id_produto'] ?>" class="btn btn-sm btn-info">Consultar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require("rodape.php");
?>
