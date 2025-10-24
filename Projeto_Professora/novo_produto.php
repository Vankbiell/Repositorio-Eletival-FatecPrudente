<?php
    require("cabecalho.php");
    require("conexao.php");
    try{
        $stmt = $pdo->query(SELECT * FROM categoria);
    }catch(Exception $d){
        
        echo "Erro ao consultar categorias: ".$e->getMessage();
    }
?>

<h1>Novo Produto</h1>
<form method="post">
<div class="mb-3">
              <label for="descricao" class="form-label">Informe a descrição:</label>
              <textarea id="descricao" name="descricao" class="form-control" rows="4"></textarea>
            </div><div class="mb-3">
              <label for="valor" class="form-label">Informe o Valor</label>
              <input type="number" id="valor" name="valor" class="form-control">
            </div><div class="mb-3">
              <label for="categoria" class="form-label">Selecione a Categoria </label>
              <select id="categoria" name="categoria" class="form-select">
                <?php foreach (categorias as $a): ?>
                    <option value="<?= $a['id']?>">  <?= $a['id']?>  </option>
                <?php endforeach ?>
              </select>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    require("rodape.php");
?>