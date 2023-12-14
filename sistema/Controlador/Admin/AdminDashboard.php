<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;
use sistema\Modelo\ServicoModelo;
use sistema\Modelo\UsuarioModelo;

/**
 * Classe AdminDashboard
 *
 * @author Fernando Aguiar
 */
class AdminDashboard extends AdminControlador
{

    /**
     * Home do admin
     * @return void
     */
    public function dashboard(): void
    {
        $servicos = new ServicoModelo();
        $usuarios = new UsuarioModelo();

        echo $this->template->renderizar('dashboard.html', [
            'servicos' => [
                'total' => $servicos->busca()->total(),
                'ativo' => $servicos->busca('status = 1')->total(),
                'inativo' => $servicos->busca('status = 0')->total()
            ],
            'usuarios' => [
                'total' => $usuarios->busca()->total(),
                'ativo' => $usuarios->busca('status = 1')->total(),
                'inativo' => $usuarios->busca('status = 0')->total()
            ],
        ]);
    }

    /**
     * Faz logout do usuário
     * @return void
     */
    public function sair(): void
    {
        $sessao = new Sessao();
        $sessao->limpar('usuarioId');

        $this->mensagem->informa('Você saiu do painel de controle!')->flash();
        Helpers::redirecionar('admin/login');
    }
}
