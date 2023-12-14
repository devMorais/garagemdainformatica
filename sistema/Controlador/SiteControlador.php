<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe SiteControlador
 *
 * Controlador responsável por gerenciar as ações do site, como exibição de páginas,
 * busca de serviços, exibição de detalhes de serviço, exibição de categorias, entre outros.
 * Utiliza modelos como ServicoModelo e CategoriaModelo para interação com o banco de dados.
 *
 * @package sistema\Controlador
 */
class SiteControlador extends Controlador
{

    /**
     * Construtor da classe SiteControlador.
     *
     * Inicializa o controlador com o diretório de templates específico para as views do site.
     */
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    /**
     * Exibe a página inicial do site com lista de serviços e categorias.
     *
     * @return void
     */
    public function index(): void
    {
        $servicos = (new ServicoModelo())->busca("status = 1");
        echo $this->template->renderizar('index.html', [
            'servicos' => $servicos->resultado(true),
            'categorias' => $this->categorias()
        ]);
    }

    /**
     * Realiza a busca de serviços com base no termo fornecido.
     *
     * @return void
     */
    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if (isset($busca)) {
            $servicos = (new ServicoModelo())->busca("status = 1 AND nome_servico LIKE '%{$busca}%'")->resultado(true);
            if ($servicos) {
                foreach ($servicos as $servico) {
                    echo "<div class='card mb-3'>
                        <div class='card-body'>
                            <h5 class='card-title'>$servico->nome_servico</h5>
                            <a href='" . Helpers::url('servico/') . $servico->id . "' class='btn btn-danger'>Detalhes</a>
                        </div>
                      </div>";
                }
            }
        }
    }

    /**
     * Exibe os detalhes de um serviço específico.
     *
     * @param int $id O ID do serviço.
     * @return void
     */
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

    /**
     * Obtém a lista de categorias.
     *
     * @return array A lista de categorias.
     */
    public function categorias()
    {
        return (new CategoriaModelo())->busca();
    }

    /**
     * Exibe os serviços associados a uma categoria específica.
     *
     * @param int $id O ID da categoria.
     * @return void
     */
    public function categoria(int $id): void
    {
        $servicos = (new CategoriaModelo())->servicos($id);
        echo $this->template->renderizar('categoria.html', [
            'servicos' => $servicos,
            'categorias' => $this->categorias()
        ]);
    }

    /**
     * Exibe a página "Sobre Nós".
     *
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'Sobre nós',
            'categorias' => $this->categorias()
        ]);
    }

    /**
     * Exibe a página de erro 404.
     *
     * @return void
     */
    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'titulo' => 'Página não encontrada',
            'categorias' => $this->categorias()
        ]);
    }
}
