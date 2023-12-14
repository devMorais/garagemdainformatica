<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;

class AdminLogin extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/admin/views');
    }

    public function login(): void
    {

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        var_dump($dados);

        echo $this->template->renderizar('login.html', []);
    }

    public function checarDados(array $dados): bool
    {
        
    }
}
