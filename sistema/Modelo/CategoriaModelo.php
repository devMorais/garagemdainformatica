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
}
