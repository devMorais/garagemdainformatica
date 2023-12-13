<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Description of ServicoModelo
 *
 * @author Hugo - CSGO
 */
class ServicoModelo
{

    public function busca(?string $termo = null): array
    {
        $termo = ($termo ? "WHERE {$termo}" : '');

        $query = "SELECT * FROM servicos {$termo} ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM servicos WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();
        return $resultado;
    }

    public function pesquisa(string $busca): array
    {
        $query = "SELECT * FROM servicos WHERE status = 1 AND nome_servico LIKE '%{$busca}%' ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function armazenar(array $dados): void
    {
        $query = "INSERT INTO servicos (categoria_id ,nome_servico, descricao_servico, status) VALUES (:categoria_id, :nome_servico, :descricao_servico, :status)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }

    public function atualizar(array $dados, int $id): void
    {
        $query = "UPDATE servicos SET categoria_id = :categoria_id, nome_servico = :nome_servico, descricao_servico = :descricao_servico, status = :status WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }

    public function deletar(int $id): void
    {
        $query = "DELETE FROM servicos WHERE id = {$id} ";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }

    public function total(?string $termo = null): int
    {
        $termo = ($termo ? "WHERE {$termo}" : '');

        $query = "SELECT * FROM servicos {$termo}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
