<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminCategorias
 *
 * @author Fernando
 */
class AdminCategorias extends AdminControlador
{

    public function listar(): void
    {
        $categorias = new CategoriaModelo();

        echo $this->template->renderizar('categorias/listar.html', [
            'categorias' => $categorias->busca()->ordem('nome_categoria ASC')->resultado(true),
            'total' => [
                'categorias' => $categorias->total(),
                'categoriasAtiva' => $categorias->busca('status = 1')->total(),
                'categoriasInativa' => $categorias->busca('status = 0')->total(),
            ]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {

                $categoria = new CategoriaModelo();

                $categoria->nome_categoria = $dados['nome_categoria'];
                $categoria->descricao_categoria = $dados['descricao_categoria'];
                $categoria->status = $dados['status'];
                $categoria->cadastrado_em = date('Y-m-d H:i:s');

                if ($categoria->salvar()) {
                    $this->mensagem->sucesso('Categoria cadastrada com sucesso')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                } else {
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }
        }

        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $dados
        ]);
    }

    public function editar(int $id): void
    {
        $categoria = (new CategoriaModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $categoria = (new CategoriaModelo())->buscaPorId($categoria->id);

                $categoria->nome_categoria = $dados['nome_categoria'];
                $categoria->descricao_categoria = $dados['descricao_categoria'];
                $categoria->status = $dados['status'];
                $categoria->atualizado_em = date('Y-m-d H:i:s');

                if ($categoria->salvar()) {
                    $this->mensagem->sucesso('Categoria atualizada com sucesso')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                } else {
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }
        }

        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $categoria
        ]);
    }

    private function validarDados(array $dados): bool
    {
        if (empty($dados['nome_categoria'])) {
            $this->mensagem->alerta('Escreva um nome para a Categoria!')->flash();
            return false;
        }

        return true;
    }

    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $categoria = (new CategoriaModelo())->buscaPorId($id);
            if (!$categoria) {
                $this->mensagem->alerta('O categoria que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            } elseif ($categoria->servicos($categoria->id)) {
                $this->mensagem->alerta("A categoria {$categoria->nome_categoria} possui serviços associados. Antes de prosseguir com a exclusão, por favor, remova ou atualize os serviços relacionados.")->flash();
                Helpers::redirecionar('admin/categorias/listar');
            } else {
                if ($categoria->deletar()) {
                    $this->mensagem->sucesso('Categoria deletada com sucesso!')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                } else {
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }
        }
    }
}
