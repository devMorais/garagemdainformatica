<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ServicoModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminServicos
 *
 * @author Ronaldo Aires
 */
class AdminServicos extends AdminControlador
{

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

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $servico = new ServicoModelo();

            $servico->nome_servico = $dados['nome_servico'];
            $servico->categoria_id = $dados['categoria_id'];
            $servico->descricao_servico = $dados['descricao_servico'];
            $servico->status = $dados['status'];

            if ($servico->salvar()) {
                $this->mensagem->sucesso('Serviço cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/servicos/listar');
            }
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

            $servico = (new ServicoModelo())->buscaPorId($id);

            $servico->nome_servico = $dados['nome_servico'];
            $servico->categoria_id = $dados['categoria_id'];
            $servico->descricao_servico = $dados['descricao_servico'];
            $servico->status = $dados['status'];

            if ($servico->salvar()) {
                $this->mensagem->sucesso('Serviço atualizado com sucesso')->flash();
                Helpers::redirecionar('admin/servicos/listar');
            }
        }

        echo $this->template->renderizar('servicos/formulario.html', [
            'servico' => $servico,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $servico = (new ServicoModelo())->buscaPorId($id);
            if (!$servico) {
                $this->mensagem->alerta('O serviço que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/servicos/listar');
            } else {
                if ($servico->deletar()) {
                    $this->mensagem->sucesso('Serviço deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                } else {
                    $this->mensagem->erro($servico->erro())->flash();
                    Helpers::redirecionar('admin/servicos/listar');
                }
            }
        }
    }
}
