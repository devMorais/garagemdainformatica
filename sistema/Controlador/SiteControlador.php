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
        // Obtém o valor da variável de busca a partir do método POST
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);

        // Verifica se a variável de busca está definida
        if (isset($busca)) {
            // Realiza a busca no modelo de Serviço
            $servicos = (new ServicoModelo())->busca("status = 1 AND nome_servico LIKE '%{$busca}%'")->resultado(true);

            // Verifica se foram encontrados resultados
            if ($servicos) {
                // Inicia a lista de resultados utilizando a classe list-group do Bootstrap
                echo '<ul class="list-group">';

                // Itera sobre os resultados e exibe cada um deles
                foreach ($servicos as $servico) {
                    echo '<li class="list-group-item border-0">';
                    echo '<a href="' . Helpers::url('servico/') . $servico->slug . '" class="text-decoration-none text-dark">';
                    echo '<h5 class="mb-0">' . $servico->nome_servico . '</h5>';
                    echo '</a>';
                    echo '</li>';
                }

                // Finaliza a lista de resultados
                echo '</ul>';
            } else {
                // Exibe uma mensagem se nenhum resultado foi encontrado
                echo '<p class="text-muted">Nenhum resultado encontrado.</p>';
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

        $servico->salvarVisitas();

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

        $categoria->salvarVisitas();

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
