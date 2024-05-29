<?php

namespace Viniciusc6\Serenato\Repository;

use PDO;
use Viniciusc6\Serenato\Model\Produto;

class ProdutoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function opcoesComida(string $tipo): array
    {
        $sqlQuery = 'SELECT * FROM produtos WHERE tipo=? ORDER BY preco;';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->bindValue(1, $tipo);
        $stmt->execute();

        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosProduto = array_map(function ($cafe) {
            return new Produto(
                $cafe['id'],
                $cafe['tipo'],
                $cafe['nome'],
                $cafe['descricao'],
                $cafe['imagem'],
                $cafe['preco']
            );
        }, $produtos);
        return $dadosProduto;
    }
}
