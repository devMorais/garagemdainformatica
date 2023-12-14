<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\ServicoModelo;
use sistema\Nucleo\Helpers;
use sistema\Modelo\CategoriaModelo;

class SiteControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    /**
     * Home Page
     * @return void
     */
    public function index(): void
    {
        $servicos = (new ServicoModelo())->busca("status = 1");
        
        echo $this->template->renderizar('index.html', [
            'servicos' => $servicos->resultado(true),
            'categorias' => $this->categorias(),
        ]);
    }
    
    public function buscar():void
    {
        $busca = filter_input(INPUT_POST,'busca', FILTER_DEFAULT);
        if(isset($busca)){
            $servicos = (new ServicoModelo())->busca("status = 1 AND nome_servico LIKE '%{$busca}%'")->resultado(true);
            
            foreach ($servicos as $servico){
                echo "<li class='list-group-item fw-bold'><a href=".Helpers::url('servico/').$servico->id.">$servico->nome_servico</a></li>";
            }
        }
        
    }
    
    /**
     * Busca servico por ID
     * @param int $id
     * @return void
     */
    public function servico(int $id):void
    {
        $servico = (new ServicoModelo())->buscaPorId($id);
        if(!$servico){
            Helpers::redirecionar('404');
        }
        
        echo $this->template->renderizar('servico.html', [
            'servico' => $servico,
            'categorias' => $this->categorias(),
        ]);
    }
    
    /**
     * Categorias
     * @return array
     */
    public function categorias(): array
    {
        return (new CategoriaModelo())->busca();
    }

    public function categoria(int $id):void
    {
        $servicos = (new CategoriaModelo())->servicos($id);
        
        echo $this->template->renderizar('categoria.html', [
            'servicos' => $servicos,
            'categorias' => $this->categorias(),
        ]);
    }
    
    /**
     * Sobre
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'nome_servico' => 'Sobre nós'
        ]);
    }
    
    /**
     * ERRO 404
     * @return void
     */
    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'nome_servico' => 'Página não encontrada'
        ]);
    }

}
