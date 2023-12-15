<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe CategoriaModelo
 *
 * @author Fernando Aguiar
 */
class CategoriaModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('categorias');
    }

    /**
     * Método para verificar se existe serviços relacionados a categoria
     * @return array|null
     */
    public function servicos(int $id): ?array
    {
        $busca = (new ServicoModelo())->busca("categoria_id = {$id}");
        return $busca->resultado(true);
    }
}
