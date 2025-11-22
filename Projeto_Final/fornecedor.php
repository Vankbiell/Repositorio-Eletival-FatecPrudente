<?php
    require("cabecalho.php");
    require("conexao.php");

    try {
        $stmt = $pdo->query("SELECT * FROM fornecedor");
        $dados = $stmt->fetchAll();
    } catch (\Exception $e) {
        echo "Erro: " . $e->getMessage();
    }

    if (isset($_GET['cadastro']) && $_GET['cadastro']) {
        echo "<p class='text-success'>Cadastro de fornecedor realizado!</p>";
    } else if (isset($_GET['cadastro']) && !$_GET['cadastro']) {
        echo "<p class='text-danger'>Erro ao cadastrar!</p>";
    }

    if (isset($_GET['editar']) && $_GET['editar']) {
        echo "<p class='text-success'>Edição de fornecedor realizada!</p>";
    } else if (isset($_GET['editar']) && !$_GET['editar']) {
        echo "<p class='text-danger'>Erro ao editar!</p>";
    }
?>

<h2>Fornecedores</h2>
<a href="novo_fornecedor.php" class="btn btn-success mb-3">Novo Registro</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($dados as $d): ?>
        <tr>
            <td><?= $d['id_fornecedor'] ?></td>
            <td><?= $d['nome_fornecedor'] ?></td>
            <td class="d-flex gap-2">
                <a href="editar_fornecedor.php?id=<?= $d['id_fornecedor'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="consultar_fornecedor.php?id=<?= $d['id_fornecedor'] ?>" class="btn btn-sm btn-info">Consultar</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php
    require("rodape.php");
?>
