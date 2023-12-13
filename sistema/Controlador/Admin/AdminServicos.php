<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Description of AdminServicos
 *
 * @author Hugo - CSGO
 */
class AdminServicos extends AdminControlador
{

    public function listar(): void
    {
        echo $this->template->renderizar('servicos/listar.html', [
            'servicos' => (new ServicoModelo())->busca()
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new ServicoModelo())->armazenar($dados);
            Helpers::redirecionar('admin/servicos/listar');
        }
        echo $this->template->renderizar('servicos/formulario.html', [
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function editar(int $id): void
    {
        $servico = (new ServicoModelo())->buscaPorId($id);
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            Helpers::redirecionar('admin/servicos/listar');
        }
        echo $this->template->renderizar('servicos/formulario.html', [
            'servico' => $servico,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }
}
