<?php
require("cabecalho.php");
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        $stmt = $pdo->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
        $stmt->execute([$_GET['id']]);
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro ao consultar fornecedor: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM fornecedor WHERE id_fornecedor = ?");

        if ($stmt->execute([$id])) {
            header('location: fornecedor.php?excluir=true');
        } else {
            header('location: fornecedor.php?excluir=false');
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<h1>Consultar Fornecedor</h1>

<form method="post">
    <input type="hidden" name="id" value="<?= $fornecedor['id_fornecedor'] ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome do fornecedor:</label>
        <input disabled value="<?= $fornecedor['nome_fornecedor'] ?>" 
               type="text" id="nome" class="form-control">
    </div>

    <p>Deseja excluir esse registro?</p>

    <button type="submit" class="btn btn-danger">Excluir</button>
    <button onclick="history.back();" type="button" class="btn btn-secondary">
        Voltar
    </button>
</form>

<?php require("rodape.php"); ?>
