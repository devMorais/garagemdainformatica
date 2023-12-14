<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe controladora responsável pelo controle dos dados dos serviços no painel administrativo.
 *
 * Esta classe fornece métodos para listar, cadastrar, editar e deletar serviços no sistema administrativo.
 * As operações são realizadas utilizando o modelo ServicoModelo para interação com o banco de dados.
 *
 * @author Hugo - CSGO
 * @package sistema\Controlador\Admin
 */
class AdminServicos extends AdminControlador
{

    /**
     * Método responsável por listar os serviços na página servicos/listar.html.
     *
     * Este método recupera a lista de serviços do banco de dados por meio do ServicoModelo
     * e renderiza a página de listagem com os serviços, totalizando ativos e inativos.
     *
     * @return void
     */
    public function listar(): void
    {
        $servico = new ServicoModelo();

        echo $this->template->renderizar('servicos/listar.html', [
            'servicos' => $servico->busca(null,'status ASC, id DESC'),
            'total' => [
                'servicos' => $servico->total(),
                'servicosAtivo' => $servico->total('status = 1'),
                'servicosInativo' => $servico->total('status = 0')
            ]
        ]);
    }

    /**
     * Método responsável por exibir o formulário de cadastro de serviços.
     *
     * Este método processa os dados submetidos via POST, cadastra o serviço utilizando o ServicoModelo
     * e redireciona para a lista de serviços após a conclusão bem-sucedida.
     *
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new ServicoModelo())->armazenar($dados);
            $this->mensagem->sucesso('Cadastrado com sucesso.')->flash();
            Helpers::redirecionar('admin/servicos/listar');
        }
        echo $this->template->renderizar('servicos/formulario.html', [
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    /**
     * Método responsável por exibir o formulário de edição de serviços.
     *
     * Este método recupera os dados do serviço com base no ID fornecido, processa os dados submetidos via POST,
     * atualiza o serviço utilizando o ServicoModelo e redireciona para a lista de serviços após a conclusão bem-sucedida.
     *
     * @param int $id O identificador único do serviço a ser editado.
     * @return void
     */
    public function editar(int $id): void
    {
        $servico = (new ServicoModelo())->buscaPorId($id);
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            (new ServicoModelo())->atualizar($dados, $id);
            $this->mensagem->sucesso('Editado com sucesso.')->flash();
            Helpers::redirecionar('admin/servicos/listar');
        }
        echo $this->template->renderizar('servicos/formulario.html', [
            'servico' => $servico,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    /**
     * Método responsável por deletar um serviço.
     *
     * Este método recebe o ID do serviço a ser deletado, realiza a exclusão utilizando o ServicoModelo
     * e redireciona para a lista de serviços após a conclusão bem-sucedida.
     *
     * @param int $id O identificador único do serviço a ser deletado.
     * @return void
     */
    public function deletar(int $id): void
    {
        (new ServicoModelo())->deletar($id);
        $this->mensagem->sucesso('Deletado com sucesso.')->flash();
        Helpers::redirecionar('admin/servicos/listar');
    }
}
