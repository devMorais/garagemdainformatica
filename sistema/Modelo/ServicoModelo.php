<?php

namespace sistema\Modelo;

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

    public function categoria(): ?CategoriaModelo
    {
        if ($this->categoria_id) {
            return (new CategoriaModelo())->buscaPorId($this->categoria_id);
        }

        return null;
    }

    public function usuario(): ?UsuarioModelo
    {
        if ($this->usuario_id) {
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }

        return null;
    }
}
