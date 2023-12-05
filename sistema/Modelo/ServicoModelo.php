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

    public function ler(): array
    {
        $query = "SELECT * FROM servicos";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}
