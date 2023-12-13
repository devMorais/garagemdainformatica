<?php

namespace sistema\Controlador\Admin;

/**
 * Description of AdminDashboard
 *
 * @author Hugo - CSGO
 */
class AdminDashboard extends AdminControlador
{

    public function dashboard(): void
    {
        echo $this->template->renderizar('dashboard.html', [
        ]);
    }
}
