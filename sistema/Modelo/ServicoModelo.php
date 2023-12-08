<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Description of ServicoModelo
 *
 * @author Hugo - CSGO
 */
class ServicoModelo
{

    public function busca(): array
    {
        $query = "SELECT * FROM servicos ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM servicos WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();
        return $resultado;
    }
}
