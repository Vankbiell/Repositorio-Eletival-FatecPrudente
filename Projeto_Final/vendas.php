<?php
    require("cabecalho.php");
    require("conexao.php");

    try{
        $stmt = $pdo->query("
            SELECT v.idvendas, v.total_venda, u.nome_usuario, u.id_usuario
            FROM vendas v
            INNER JOIN usuario u ON v.usuario_id_usuario = u.id_usuario
            ORDER BY v.idvendas DESC
        ");
        $dados = $stmt->fetchAll();
    } catch(\Exception $e){
        echo "Erro: ".$e->getMessage();
    }

    // Mensagens de retorno
    if (isset($_GET['cadastro']) && $_GET['cadastro']){
        echo "<p class='text-success'>Venda realizada com sucesso!</p>";
    } else if (isset($_GET['cadastro']) && !$_GET['cadastro']){
        echo "<p class='text-danger'>Erro ao realizar venda!</p>";
    }
    if (isset($_GET['editar']) && $_GET['editar']){
        echo "<p class='text-success'>Venda editada com sucesso!</p>";
    } else if (isset($_GET['editar']) && !$_GET['editar']){
        echo "<p class='text-danger'>Erro ao editar venda!</p>";
    }
    if (isset($_GET['excluir']) && $_GET['excluir']){
        echo "<p class='text-success'>Venda excluída com sucesso!</p>";
    } else if (isset($_GET['excluir']) && !$_GET['excluir']){
        echo "<p class='text-danger'>Erro ao excluir venda!</p>";
    }
?>

<h2>Vendas</h2>
<a href="nova_venda.php" class="btn btn-success mb-3">Nova Venda</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID Venda</th>
            <th>Total</th>
            <th>Usuário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dados as $d): ?>
        <tr>
            <td><?= $d['idvendas'] ?></td>
            <td>R$ <?= number_format($d['total_venda'], 2, ',', '.') ?></td>
            <td><?= $d['nome_usuario'] ?></td>
            <td class="d-flex gap-2">
                <a href="editar_venda.php?id=<?= $d['idvendas'] ?>&usuario_id=<?= $d['id_usuario'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="consultar_venda.php?id=<?= $d['idvendas'] ?>&usuario_id=<?= $d['id_usuario'] ?>" class="btn btn-sm btn-info">Consultar</a>
                <a href="excluir_venda.php?id=<?= $d['idvendas'] ?>&usuario_id=<?= $d['id_usuario'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta venda?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require("rodape.php");
?>