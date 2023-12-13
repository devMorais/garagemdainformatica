<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;

/**
 * Description of AdminControlador
 *
 * @author Hugo - CSGO
 */
class AdminControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/admin/views');
    }
}
