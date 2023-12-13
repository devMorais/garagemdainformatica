<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Description of CategoriaModelo
 *
 * @author Hugo - CSGO
 */
class CategoriaModelo
{

    public function busca(): array
    {
        $query = "SELECT * FROM categorias WHERE status = 1 ORDER BY nome_categoria ASC";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM categorias WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();
        return $resultado;
    }

    public function servicos(int $id): array
    {
        $query = "SELECT * FROM servicos WHERE categoria_id = {$id} AND status = 1 ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function armazenar(array $dados): void
    {
        $query = "INSERT INTO `categorias` (`nome_categoria`, `descricao_categoria`, `status`) VALUES (?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome_categoria'], $dados['descricao_categoria'], $dados['status']]);
    }

    public function atualizar(array $dados, int $id): void
    {
        $query = "UPDATE categorias SET nome_categoria = ?, descricao_categoria = ?, status = ? WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome_categoria'], $dados['descricao_categoria'], $dados['status']]);
    }

    public function deletar(int $id): void
    {
        $query = "DELETE FROM categorias WHERE id = {$id} ";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }
}
