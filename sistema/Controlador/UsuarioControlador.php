<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Sessao;
use sistema\Modelo\UsuarioModelo;

//use sistema\Nucleo\Helpers;

class UsuarioControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    public static function usuario(): ?UsuarioModelo
    {
        $sessao = new Sessao();
        if (!$sessao->checar('usuarioId')) {
            return null;
        }

        return (new UsuarioModelo())->buscaPorId($sessao->usuarioId);
    }
}
