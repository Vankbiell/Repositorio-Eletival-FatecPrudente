<?php
    require("cabecalho.php");
    require("conexao.php");

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        try{
            $stmt = $pdo->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
            $stmt->execute([$_GET['id']]);
            $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e){
            echo "Erro ao consultar fornecedor: ".$e->getMessage();
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];
        $id = $_POST['id'];

        try{
            $stmt = $pdo->prepare("UPDATE fornecedor SET nome_fornecedor = ? WHERE id_fornecedor = ?");
            if($stmt->execute([$nome, $id])){
                header('location: fornecedor.php?editar=true');
            } else {
                header('location: fornecedor.php?editar=false');
            }
        }catch(\Exception $e){
            echo "Erro: ".$e->getMessage();
        }
    }
?>

<h1>Editar Fornecedor</h1>

<form method="post">
    <input type="hidden" name="id" value="<?= $fornecedor['id_fornecedor'] ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Informe o nome do fornecedor:</label>
        <input value="<?= $fornecedor['nome_fornecedor'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php require("rodape.php"); ?>
