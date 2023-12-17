<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminServicos
 *
 * @author Fernando Aguiar
 */
class AdminServicos extends AdminControlador
{

    /**
     * Lista servicos
     * @return void
     */
    public function listar(): void
    {
        $servico = new ServicoModelo();

        echo $this->template->renderizar('servicos/listar.html', [
            'servicos' => $servico->busca()->ordem('status ASC, id DESC')->resultado(true),
            'total' => [
                'servicos' => $servico->total(),
                'servicosAtivo' => $servico->busca('status = 1')->total(),
                'servicosInativo' => $servico->busca('status = 0')->total()
            ]
        ]);
    }

    /**
     * Cadastra servicos
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $servico = new ServicoModelo();

                $servico->usuario_id = $this->usuario->id;
                $servico->categoria_id = $dados['categoria_id'];
                $servico->slug = Helpers::slug($dados['nome_servico']);
                $servico->nome_servico = $dados['nome_servico'];
                $servico->descricao_servico = $dados['descricao_servico'];
                $servico->status = $dados['status'];

                if ($servico->salvar()) {
                    $this->mensagem->sucesso('Serviço cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                } else {
                    $this->mensagem->erro($servico->erro())->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                }
            }
        }

        echo $this->template->renderizar('servicos/formulario.html', [
            'categorias' => (new CategoriaModelo())->busca()->resultado(true),
            'servico' => $dados
        ]);
    }

    /**
     * Edita servico pelo ID
     * @param int $id
     * @return void
     */
    public function editar(int $id): void
    {
        $servico = (new ServicoModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $servico = (new ServicoModelo())->buscaPorId($id);

                $servico->usuario_id = $this->usuario->id;
                $servico->categoria_id = $dados['categoria_id'];
                $servico->slug = Helpers::slug($dados['nome_servico']);
                $servico->nome_servico = $dados['nome_servico'];
                $servico->descricao_servico = $dados['descricao_servico'];
                $servico->status = $dados['status'];
                $servico->atualizado_em = date('Y-m-d H:i:s');

                if ($servico->salvar()) {
                    $this->mensagem->sucesso('Serviço atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                } else {
                    $this->mensagem->erro($servico->erro())->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                }
            }
        }

        echo $this->template->renderizar('servicos/formulario.html', [
            'servico' => $servico,
            'categorias' => (new CategoriaModelo())->busca()->resultado(true)
        ]);
    }

    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {
        if (empty($dados['nome_servico'])) {
            $this->mensagem->alerta('Escreva um título para o Serviço!')->flash();
            return false;
        }
        if (empty($dados['descricao_servico'])) {
            $this->mensagem->alerta('Escreva um descricão para o Serviço!')->flash();
            return false;
        }

        return true;
    }

    /**
     * Deleta servicos por ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $servico = (new ServicoModelo())->buscaPorId($id);
            if (!$servico) {
                $this->mensagem->alerta('O servico que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/servicos/listar');
            } else {
                if ($servico->deletar()) {
                    $this->mensagem->sucesso('Servico deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                } else {
                    $this->mensagem->erro($servico->erro())->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                }
            }
        }
    }
}
