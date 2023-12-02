<?php

//Arquivo index responsável pela inicialização do sistema
require_once 'sistema/configuracao.php';
include_once './sistema/Nucleo/Helpers.php';
include './sistema/Nucleo/Mensagem.php';
include './sistema/Nucleo/Controlador.php';

use sistema\Nucleo\Controlador;



$controlador = new Controlador();
echo '<hr>';
var_dump($controlador);



