<?php
require_once 'vendor/autoload.php';
require "src/conexao-bd.php";

use Viniciusc6\Serenato\Repository\ProdutoRepository;

$produtoRepository = new ProdutoRepository($pdo);


$produtoRepository->deletar($_POST['id']);

header('Location:admin.php');
