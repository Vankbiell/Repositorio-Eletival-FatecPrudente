<?php
    require("cabecalho.php");
    require("conexao.php");
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        try{
            $stmt = $pdo->prepare("SELECT * from produto WHERE id_produto = ?");
            $stmt->execute([$_GET['id_produto']]);
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e){
            echo "Erro ao consultar produto: ".$e->getMessage();
        }
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $id_produto = $_POST['id_produto'];
        try{
            $stmt = 
                $pdo->prepare("DELETE from produto WHERE id_produto = ?");
            if($stmt->execute([$id_produto])){
                header('location: produto.php?excluir=true');
            } else {
                header('location: produto.php?excluir=false');
            }
        }catch(\Exception $e){
            echo "Erro: ".$e->getMessage();
        }
    }
?>

    <h1>Consultar Produto</h1>
    <form method="post">
        <input type="hidden" name="id_produto" value="<?= $pr['id_produto'] ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da produto:</label>
            <input disabled value="<?= $pr['nome']?>" type="text" id_produto="nome" name="nome" class="form-control" required="">
        </div>
        <p>Deseja excluir esse registro?</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <button onclick="history.back();" type="button" class="btn btn-secondary">
            Voltar
        </button>
    </form>

<?php
    require("rodape.php");
?>