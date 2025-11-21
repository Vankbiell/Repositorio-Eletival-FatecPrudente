<?php
    require("cabecalho.php");
    require("conexao.php");
    try{
        $stmt = $pdo->query("SELECT * FROM fornecedor");
        $fornecedor = $stmt->fetchAll();
        $stmt = $pdo->prepare("SELECT * FROM produto WHERE id_produto = ?");
        $stmt->execute([$_GET['id_produto']]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "Erro ao consultar fornecedor: ".$e->getMessage();
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $descricao_produto = $_POST['descricao_produto'];
        $valor_produto = $_POST['valor_produto'];
        $fornecedor = $_POST['fornecedor'];
        $id_produto = $_POST['id_produto'];
        try{
            $stmt = $pdo->prepare("
                UPDATE produto SET descricao_produto = ?, valor_produto = ?, fornecedor_id_produto = ?
                WHERE id_produto = ?
            ");
            if($stmt->execute([$descricao_produto, $valor_produto, $fornecedor, $id_produto])){
                header("location: produto.php?editar=true");
            }else{
                header("location: produto.php?editar=false");
            }
        } catch(Exception $e){
            echo "Erro ao editar: ".$e->getMessage();
        }
    }

?>

<h1>Editar Produto</h1>
<form method="post">
    <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
    <div class="mb-3">
        <label for="descricao_produto" class="form-label">Informe a descrição</label>
        <textarea id="descricao_produto" name="descricao_produto" class="form-control" rows="4" required=""><?= $produto['descricao'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="valor_produto" class="form-label">Informe o valor</label>
        <input value="<?= $produto['valor_produto'] ?>" type="number" id="valor_produto" name="valor" class="form-control" required="">
    </div>
    <div class="mb-3">
        <label for="fornecedor" class="form-label">Selecione o fornecedor</label>
        <select id="fornecedor" name="fornecedor" class="form-select" required="">
            <?php foreach ($fornecedor as $a): ?>
                <option value="<?= $a['id_fornecedor'] ?>"  
                        <?= $a['id_fornecedor'] == $produto['fronecedor_has_produto'] ? "selected" : "" ?> >  
                    <?= $a['nome_fornecedor'] ?>  
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    require("rodape.php");
?>