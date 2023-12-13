<?php

namespace sistema\Suporte;

use Twig\Lexer;
use sistema\Nucleo\Helpers;
use sistema\Controlador\UsuarioControlador;

/**
 * Classe Template
 *
 * Esta classe é responsável por gerenciar a renderização de views utilizando o mecanismo de templates Twig.
 * Ela fornece métodos para configurar e renderizar as views, além de integrar funções úteis através da classe Helpers.
 *
 * @package sistema\Suporte
 */
class Template
{

    /** @var \Twig\Environment $twig O ambiente Twig para renderização de templates. */
    private \Twig\Environment $twig;

    /**
     * Construtor da classe Template.
     *
     * @param string $diretorio O diretório onde os templates estão localizados.
     */
    public function __construct(string $diretorio)
    {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

        $lexer = new Lexer($this->twig, array(
            $this->helpers()
        ));
        $this->twig->setLexer($lexer);
    }

    /**
     * Método responsável por realizar a renderização das views.
     *
     * @param string $view  O nome da view a ser renderizada.
     * @param array  $dados Os dados a serem passados para a view.
     *
     * @return string O conteúdo renderizado da view.
     */
    public function renderizar(string $view, array $dados): string
    {
        return $this->twig->render($view, $dados);
    }

    /**
     * Método privado responsável por adicionar funções da classe Helpers ao ambiente Twig.
     *
     * @return void
     */
    private function helpers(): void
    {
        array(
            $this->twig->addFunction(
                    new \Twig\TwigFunction('url', function (string $url = null) {
                                return Helpers::url($url);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('saudacao', function () {
                                return Helpers::saudacao();
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('resumirTexto', function (string $texto, int $limite) {
                                return Helpers::resumirTexto($texto, $limite, null);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('flash', function () {
                                return Helpers::flash();
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('usuario', function () {
                                return UsuarioControlador::usuario();
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('contarTempo', function (string $data = null) {
                                return Helpers::contarTempo($data);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('formatarNumero', function (int $numero) {
                                return Helpers::formatarNumero($numero);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('tempoCarregamento', function () {
                                $tempoTotal = microtime(true) - filter_var($_SERVER["REQUEST_TIME_FLOAT"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                return number_format($tempoTotal, 2);
                            })
            ),
            $this->twig->addFunction(
                    new \Twig\TwigFunction('horasComFusoBrasilia', function ($horario) {
                                return Helpers::horasComFusoBrasilia($horario);
                            })
            ),
        );
    }
}
