<?php
include("cabecalho.php");
?>
<div class="container py-3">
    <form method="post">
    <div class="mb-3">
        <?php for($i=1;$i<=2;$i++): ?>
        <h5>Informe o nome e telefone do seu contato</h5>
        <label for="nome[]" class="form-label">Nome: </label>
        <input type="text" id="nome[]" name="nome[]" class="form-control" required="">
        <label for="numero[]" class="form-label">Número</label>
        <input type="number" id="numero[]" name="numero[]" class="form-control" required="">
        <?php endfor; ?>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vetor_nome = $_POST['valor'];
    $vetor_numero = $_POST['numero'];
    foreach($vetor_nome && $vetor_numero as $v){
      echo"<p>$vetor_nome, $vetor_numero, $v</p>";
    }
}
include ("rodape.php");
?>