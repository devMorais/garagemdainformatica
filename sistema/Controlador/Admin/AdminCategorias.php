<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe controladora responsável pelo controle dos dados das categorias no painel administrativo.
 *
 * Esta classe fornece métodos para listar, cadastrar, editar e deletar categorias no sistema administrativo.
 * As operações são realizadas utilizando o modelo CategoriaModelo para interação com o banco de dados.
 *
 * @author Hugo - CSGO
 * @package sistema\Controlador\Admin
 */
class AdminCategorias extends AdminControlador
{

    /**
     * Método responsável por listar as categorias na página categorias/listar.html.
     *
     * Este método recupera a lista de categorias do banco de dados por meio do CategoriaModelo
     * e renderiza a página de listagem com as categorias, totalizando ativas e inativas.
     *
     * @return void
     */
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

    /**
     * Método responsável por exibir o formulário de cadastro de categorias.
     *
     * Este método processa os dados submetidos via POST, cadastra a categoria utilizando o CategoriaModelo
     * e redireciona para a lista de categorias após a conclusão bem-sucedida.
     *
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new CategoriaModelo())->armazenar($dados);
            $this->mensagem->sucesso('Cadastrado com sucesso.')->flash();
            Helpers::redirecionar('admin/categorias/listar');
        }
        echo $this->template->renderizar('categorias/formulario.html', []);
    }

    /**
     * Método responsável por exibir o formulário de edição de categorias.
     *
     * Este método recupera os dados da categoria com base no ID fornecido, processa os dados submetidos via POST,
     * atualiza a categoria utilizando o CategoriaModelo e redireciona para a lista de categorias após a conclusão bem-sucedida.
     *
     * @param int $id O identificador único da categoria a ser editada.
     * @return void
     */
    public function editar(int $id): void
    {
        $categoria = (new CategoriaModelo())->buscaPorId($id);
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new CategoriaModelo())->atualizar($dados, $id);
            $this->mensagem->sucesso('Editado com sucesso.')->flash();
            Helpers::redirecionar('admin/categorias/listar');
        }
        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $categoria,
        ]);
    }

    /**
     * Método responsável por deletar uma categoria.
     *
     * Este método recebe o ID da categoria a ser deletada, realiza a exclusão utilizando o CategoriaModelo
     * e redireciona para a lista de categorias após a conclusão bem-sucedida.
     *
     * @param int $id O identificador único da categoria a ser deletada.
     * @return void
     */
    public function deletar(int $id): void
    {
        (new CategoriaModelo())->deletar($id);
        $this->mensagem->sucesso('Deletado com sucesso.')->flash();
        Helpers::redirecionar('admin/categorias/listar');
    }
}
