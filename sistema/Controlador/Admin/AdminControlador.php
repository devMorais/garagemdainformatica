<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminControlador
 *
 * Controlador base para a área administrativa do sistema. Estende a classe Controlador do Núcleo
 * e define o diretório de templates específico para as views administrativas.
 *
 * @package sistema\Controlador\Admin
 */
class AdminControlador extends Controlador
{

    /**
     * Construtor da classe AdminControlador.
     *
     * Inicializa o controlador com o diretório de templates específico para as views administrativas.
     */
    public function __construct()
    {
        parent::__construct('templates/admin/views');

        $usuario = false;

        if (!$usuario) {
            $this->mensagem->erro('Faça login para acessar o painel de controle!')->flash();
            Helpers::redirecionar('admin/login');
        }
    }
}
