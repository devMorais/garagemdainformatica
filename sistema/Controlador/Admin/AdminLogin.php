<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Helpers;
use sistema\Controlador\UsuarioControlador;

class AdminLogin extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/admin/views');
    }

    public function login(): void
    {

        $usuario = UsuarioControlador::usuario();
        if ($usuario && $usuario->level == 3) {
            Helpers::redirecionar('admin/dashboard');
        }

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->checarDados($dados)) {
                $usuario = (new UsuarioModelo())->login($dados, 3);
                if ($usuario) {
                    Helpers::redirecionar('admin/login');
                }
            }
        }

        echo $this->template->renderizar('login.html', []);
    }

    public function checarDados(array $dados): bool
    {
        if (in_array('', $dados)) {
            $this->mensagem->alerta('Todos os campos são obrigatórios!')->flash();
            return false;
        }
        return true;
    }
}
