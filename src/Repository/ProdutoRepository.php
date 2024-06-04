<?php

namespace Viniciusc6\Serenato\Repository;

use PDO;
use PDOStatement;
use Viniciusc6\Serenato\Model\Produto;

class ProdutoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllProdutos(): array
    {
        $sqlQuery = 'SELECT * FROM produtos ORDER BY preco;';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute();
        $produtos = $this->sanitizeProduto($stmt);
        return $produtos;
    }

    public function opcoesComida(string $tipo): array
    {
        $sqlQuery = 'SELECT * FROM produtos WHERE tipo=? ORDER BY preco;';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $tipo);
        $stmt->execute();
        $produtos = $this->sanitizeProduto($stmt);
        return $produtos;
    }

    public function buscaPorId(int $id): Produto
    {
        $sqlQuery = 'SELECT * FROM produtos WHERE id=?;';

        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $produto  = $stmt->fetch(PDO::FETCH_ASSOC);

        $produtoSanitize = new Produto(
            $produto['id'],
            $produto['tipo'],
            $produto['nome'],
            $produto['descricao'],
            $produto['preco'],
            $produto['imagem']

        );
        return $produtoSanitize;
    }

    private function sanitizeProduto(PDOStatement $stmt): array
    {
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosProduto = array_map(function ($produto) {
            return new Produto(
                $produto['id'],
                $produto['tipo'],
                $produto['nome'],
                $produto['descricao'],
                $produto['preco'],
                $produto['imagem']
            );
        }, $produtos);
        return $dadosProduto;
    }

    public function salvar(Produto $produto)
    {
        $sqlQuery = "INSERT INTO produtos(tipo,nome,descricao,preco,imagem) VALUES(?,?,?,?,?);";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $produto->getTipo());
        $stmt->bindValue(2, $produto->getNome());
        $stmt->bindValue(3, $produto->getDescricao());
        $stmt->bindValue(4, $produto->getPreco());
        $stmt->bindValue(5, $produto->getImagem());
        $stmt->execute();
    }

    public function atualizar(Produto $produto)
    {
        $sqlQuery = "UPDATE produtos SET tipo=?,nome=?,descricao=?,preco=?,imagem=? WHERE id=?;";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $produto->getTipo());
        $stmt->bindValue(2, $produto->getNome());
        $stmt->bindValue(3, $produto->getDescricao());
        $stmt->bindValue(4, $produto->getPreco());
        $stmt->bindValue(5, $produto->getImagem());
        $stmt->bindValue(6, $produto->getId());
        $stmt->execute();
    }

    public function deletar(int $id): void
    {
        $sqlQuery = 'DELETE FROM produtos WHERE id=?';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}
