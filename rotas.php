<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    //DEFINIÇÃO DO NAMESPACE
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    //ROTAS DO SITE FRONT-END
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . 'servico/{id}', 'SiteControlador@servico');
    SimpleRouter::get(URL_SITE . 'categoria/{id}', 'SiteControlador@categoria');
    SimpleRouter::post(URL_SITE . 'buscar', 'SiteControlador@buscar');
    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');

    //GRUPO DE ROTAS DO PAINEL ADMINISTRATIVO
    SimpleRouter::group(['namespace' => 'Admin'], function () {


        //ROTA LOGIN ADMINISTRATIVO
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'login', 'AdminLogin@login');

        //ROTA PARA O DASHBOARD
        SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN . 'sair', 'AdminDashboard@sair');

        //ADMIN SERVICOS
        SimpleRouter::get(URL_ADMIN . 'servicos/listar', 'AdminServicos@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'servicos/cadastrar', 'AdminServicos@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'servicos/editar/{id}', 'AdminServicos@editar');
        SimpleRouter::get(URL_ADMIN . 'servicos/deletar/{id}', 'AdminServicos@deletar');

        //ADMIN CATEGORIAS
        SimpleRouter::get(URL_ADMIN . 'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN . 'categorias/deletar/{id}', 'AdminCategorias@deletar');
    });

    SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if (Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}
