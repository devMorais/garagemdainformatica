<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

class SiteControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    public function index(): void
    {
        $servicos = (new ServicoModelo())->busca();
        echo $this->template->renderizar('index.html', [
            'servicos' => $servicos,
            'categorias' => $this->categorias()
        ]);
    }

    public function servico(int $id): void
    {
        $servico = (new ServicoModelo())->buscaPorId($id);
        if (!$servico) {
            Helpers::redirecionar('404');
        }
        echo $this->template->renderizar('servico.html', [
            'servico' => $servico,
            'categorias' => $this->categorias()
        ]);
    }

    public function categorias()
    {
        return (new CategoriaModelo())->busca();
    }

    public function categoria(int $id): void
    {
        $servicos = (new CategoriaModelo())->servicos($id);
        echo $this->template->renderizar('categoria.html', [
            'servicos' => $servicos,
            'categorias' => $this->categorias()
        ]);
    }

    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'Sobre nós',
            'categorias' => $this->categorias()
        ]);
    }

    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'titulo' => 'Página não encontrada',
            'categorias' => $this->categorias()
        ]);
    }
}
