<?php
    require("cabecalho.php");
    require("conexao.php");
    try{
        $stmt = $pdo->query("SELECT * FROM fornecedor");
        $fornecedor = $stmt->fetchALL();
    }catch(Exception $d){
        
        echo "Erro ao consultar fornecedor: ".$e->getMessage();
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $descricao_produto = $_POST['descricao_produto'];
        $valor_produto = $_POST['valor_produto'];
        $fornecedor = $_POST['fornecedor'];
        try{
            $stmt = $pdo->prepare("INSERT INTO produto (descricao_produto, valor_produto, fronecedor_has_produto_id_prod_forn) VALUES(?, ?, ?)");
            if($stmt->execute([$descricao, $valor, $fornecedor])){
                header("locatiom: produto.php?cadastro=true");
            }
            else{
                header("locatiom: produto.php?cadastro=false");
            }
        }catch (Exception $e){
            echo "Erro ao inserir: ".$e->getMessage();
        }
    }
?>

<h1>Novo Produto</h1>
<form method="post">
<div class="mb-3">
              <label for="descricao_produto" class="form-label">Informe a descrição:</label>
              <textarea id="descricacao" name="descricacao" class="form-control" rows="4"></textarea>
            </div><div class="mb-3">
              <label for="valor_produto" class="form-label">Informe o Valor</label>
              <input type="number" id="valor_produto" name="valor_produto" class="form-control">
            </div><div class="mb-3">
              <label for="fornecedor" class="form-label">Selecione a Categoria </label>
              <select id="fornecedor" name="fornecedor" class="form-select">
                <?php foreach (fornecedor as $a): ?>
                    <option value="<?= $a['id_produto']?>">  <?= $a['id_fornecedor']?>  </option>
                <?php endforeach ?>
              </select>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    require("rodape.php");
?>