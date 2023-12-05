<?php

//Arquivo index responsável pela inicialização do sistema
require'vendor/autoload.php';

//require'rotas.php';

use sistema\Modelo\ServicoModelo;

$servicos = (new ServicoModelo())->ler();

foreach ($servicos as $servico){
    echo $servico->nome_servico.'<br>';
}