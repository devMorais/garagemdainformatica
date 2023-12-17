<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\ServicoModelo;
use sistema\Nucleo\Helpers;
use sistema\Modelo\CategoriaModelo;

class SiteControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    /**
     * Home Page
     * @return void
     */
    public function index(): void
    {
        $servicos = (new ServicoModelo())->busca();

        echo $this->template->renderizar('index.html', [
            'servicos' => $servicos->resultado(true),
            'categorias' => $this->categorias(),
        ]);
    }

    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if (isset($busca)) {
            $servicos = (new ServicoModelo())->busca("status = 1 AND nome_servico LIKE '%{$busca}%'")->resultado(true);

            if ($servicos) {
                foreach ($servicos as $servico) {
                    echo "<li class='list-group-item fw-bold'><a href=" . Helpers::url('servico/') . $servico->id . ">$servico->nome_servico</a></li>";
                }
            }
        }
    }

    /**
     * Busca servico por uma SLUG
     * @param string $slug
     * @return void
     */
    public function servico(string $slug): void
    {
        $servico = (new ServicoModelo())->buscaPorSlug($slug);

        if (!$servico) {
            Helpers::redirecionar('404');
        }
        $servico->visitas += 1;
        $servico->ultima_visita_em = date('Y-m-d H:i:s');
        $servico->salvar();

        echo $this->template->renderizar('servico.html', [
            'servico' => $servico,
            'categorias' => $this->categorias(),
        ]);
    }

    /**
     * Categorias
     * @return array
     */
    public function categorias(): ?array
    {
        return (new CategoriaModelo())->busca("status = 1")->resultado(true);
    }

    /**
     * Lista serviços por categoria
     * @param string $slug
     * @return void
     */
    public function categoria(string $slug): void
    {
        $categoria = (new CategoriaModelo())->buscaPorSlug($slug);
        $servicoPorCategoria = (new CategoriaModelo())->servicos($categoria->id);
        if (!$servicoPorCategoria) {
            $this->mensagem->informa("Serviços nesta categoria não estão disponíveis atualmente. Agradecemos sua compreensão.")->flash();
        } elseif (!$categoria) {
            Helpers::redirecionar('404');
        }

        $categoria->visitas += 1;
        $categoria->ultima_visita_em = date('Y-m-d H:i:s');
        $categoria->salvar();

        echo $this->template->renderizar('categoria.html', [
            'servicos' => $servicoPorCategoria,
            'categorias' => $this->categorias(),
            'categoria' => $categoria
        ]);
    }

    /**
     * Sobre
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'nome_servico' => 'Sobre nós'
        ]);
    }

    /**
     * ERRO 404
     * @return void
     */
    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'nome_servico' => 'Página não encontrada'
        ]);
    }
}
