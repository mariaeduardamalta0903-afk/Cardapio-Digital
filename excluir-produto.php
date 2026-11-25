<?php

require "src/conexao-bd.php";
require "src/modelo/produto.php";
require "src/repositorio/produtorepositorio.php";

$produtoRepositorio = new produtorepositorio($pdo);
$produtoRepositorio->deletar($_GET['id']);

header("Location: admin.php");