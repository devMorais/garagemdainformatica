<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Modelo;

/**
 * Classe ServicoModelo
 *
 * @author Fernando Aguiar
 */
class ServicoModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('servicos');
    }
}
