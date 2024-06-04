<?php

use Viniciusc6\Serenato\Model\Produto;
use Viniciusc6\Serenato\Repository\ProdutoRepository;

require 'src/conexao-bd.php';
require_once 'vendor/autoload.php';


$produtoRepository = new ProdutoRepository($pdo);

/** @var Produto[] */
$produtos = $produtoRepository->getAllProdutos();
?>

<style>
    table {
        width: 90%;
        margin: auto 0;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    table th {
        padding: 11px 0 11px;
        font-weight: bold;
        font-size: 18px;
        text-align: left;
        padding: 8px;
    }

    table tr {
        border: 1px solid #000;
    }

    table td {
        font-size: 18px;
        padding: 8px;
    }

    .container-admin-banner h1 {
        margin-top: 40px;
        font-size: 30px;
    }
</style>

<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Descricão</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($produtos as $produto) :
        ?>
            <tr>
                <td><?= $produto->getNome() ?></td>
                <td><?= $produto->getTipo() ?></td>
                <td><?= $produto->getDescricao() ?></td>
                <td><?= $produto->getPrecoFromatado() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>