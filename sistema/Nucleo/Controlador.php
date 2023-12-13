<?php

namespace sistema\Nucleo;

use sistema\Suporte\Template;

/**
 * Classe Controlador
 *
 * Esta classe serve como uma base para outros controladores no sistema. Ela fornece instâncias
 * dos objetos Template e Mensagem, que podem ser utilizados pelos controladores filhos para
 * renderização de views e manipulação de mensagens.
 *
 * @package sistema\Controlador
 */
class Controlador
{

    /**
     * @var Template $template Instância do objeto Template para renderização de views.
     */
    protected Template $template;

    /**
     * @var Mensagem $mensagem Instância do objeto Mensagem para manipulação de mensagens.
     */
    protected Mensagem $mensagem;

    /**
     * Construtor da classe Controlador.
     *
     * @param string $diretorio O diretório onde os templates estão localizados.
     */
    public function __construct(string $diretorio)
    {
        $this->template = new Template($diretorio);
        $this->mensagem = new Mensagem();
    }
}
