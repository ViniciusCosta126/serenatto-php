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

    private function sanitizeProduto(PDOStatement $stmt): array
    {
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosProduto = array_map(function ($produto) {
            return new Produto(
                $produto['id'],
                $produto['tipo'],
                $produto['nome'],
                $produto['descricao'],
                $produto['imagem'],
                $produto['preco']
            );
        }, $produtos);
        return $dadosProduto;
    }

    public function deletar(int $id): void
    {
        $sqlQuery = 'DELETE FROM produtos WHERE id=?';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}
