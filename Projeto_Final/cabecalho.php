<?php
  session_start();
  if(!isset($_SESSION['acesso']))
    header('location: index.php');
?>
