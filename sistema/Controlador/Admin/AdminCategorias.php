<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Description of AdminCategorias
 *
 * @author Hugo - CSGO
 */
class AdminCategorias extends AdminControlador
{

    public function listar(): void
    {
        $categorias = new CategoriaModelo();
        echo $this->template->renderizar('categorias/listar.html', [
            'categorias' => $categorias->busca(),
            'total' => [
                'categorias' => $categorias->total(),
                'categoriasAtiva' => $categorias->total('status = 1'),
                'categoriasInativa' => $categorias->total('status = 0')
            ]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new CategoriaModelo())->armazenar($dados);
            Helpers::redirecionar('admin/categorias/listar');
        }
        echo $this->template->renderizar('categorias/formulario.html', []);
    }

    public function editar(int $id): void
    {
        $categoria = (new CategoriaModelo())->buscaPorId($id);
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new CategoriaModelo())->atualizar($dados, $id);
            Helpers::redirecionar('admin/categorias/listar');
        }
        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $categoria,
        ]);
    }

    public function deletar(int $id): void
    {
        (new CategoriaModelo())->deletar($id);
        Helpers::redirecionar('admin/categorias/listar');
    }
}
