<?php
  session_start();
  if(!isset($_SESSION['acesso']))
    header('location: index.php');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciador de Vendas </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Gerenciador de Vendas </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Cadastros
  </a>
  <ul class="dropdown-menu" aria-labelledby="dropdown1">
    <li><a class="dropdown-item" href="produto.php">Produtos</a></li>
<li><a class="dropdown-item" href="fornecedor.php">Fornecedor</a></li>
<li><a class="dropdown-item" href="vendas.php">Vendas</a></li>
  </ul>
</li>

<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Relatórios
  </a>
  <ul class="dropdown-menu" aria-labelledby="dropdown2">
    <li><a class="dropdown-item" href="#">Vendas</a></li>
<li><a class="dropdown-item" href="#">Estoque</a></li>
  </ul>
</li>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-3">
