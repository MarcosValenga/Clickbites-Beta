<?php

//require './core/Config.php';

namespace Core;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Recebe a URL e manipula
 * Carregar a CONTROLLER
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class ConfigController extends Config
{
    /** @var string $url Recebe a URL do .htacces*/
    private string $url;
    /** @var array $urlArray Recebe a URL convertida para array */
    private array $urlArray;
    /** @var string $urlController recebe da URL o noma da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParameter Recebe da URL o parametro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;
    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;

    public function __construct()
    {
        $this->configAdm();
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            //var_dump($this->url);
            $this->clearUrl();
            $this->urlArray = explode("/", $this->url);
            //var_dump($this->urlArray);

            if (isset($this->urlArray[0])) {
                //var_dump($this->urlArray[0]);
                $this->urlController = $this->slugController($this->urlArray[0]);
                //var_dump($this->urlController);
            } else {
                $this->urlController = $this->slugController(CONTROLLER);
            }

            if (isset($this->urlArray[1])) {
                $this->urlMetodo = $this->slugMetodo($this->urlArray[1]);
            } else {
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            if (isset($this->urlArray[2])) {
                $this->urlParameter = $this->urlArray[2];
            } else {
                $this->urlParameter = "";
            }
        } else {
            //var_dump("Passou aqui");
            $this->urlController = $this->slugController(CONTROLLERERRO);
            $this->urlMetodo = METODO;
            $this->urlParameter = "";
        }
        //echo "Controller: {$this->urlController} <br>";
        //echo "Metodo: {$this->urlMetodo} <br>";
        //echo "Paramentro: {$this->urlParameter} <br>";
    }

    /**
     * Método privado não pode ser instanciado fora da classe
     * Limpara a URL, eliminado as TAG, os espaços em branco, retirar a barra no final
     * da URL e retirar os caractes especiais
     * @return void
     */
    private function clearUrl(): void
    {
        //Eliminar as tags
        $this->url = strip_tags($this->url);
        //Eliminar espaço em branco
        $this->url = trim($this->url);
        //Eliminar a barra no final da URL
        $this->url = rtrim($this->url, "/");
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']);
    }

    /**
     * Converter o valor obtido da URL "view-users" e converter no formato da classe "ViewUser"
     * Utilizado as funções para converter tudo par minúsculo, converter o traço pelo espaço,
     * converter cada letra da primeira palavra para maiúsculo, retirar
     * os espaços em branco
     * 
     * @param string $slugController Nome da classe
     * @return string Retona a controller "view-users" convertido para o nome da classe "ViewUser"
     *
     */
    private function slugController($slugController) :string
    {
        $this->urlSlugController = $slugController;
        //var_dump($this->urlSlugController);
        //Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        //var_dump($this->urlSlugController);
        //Converter traço para espaço em branco
        $this->urlSlugController = str_replace("-"," ", $this->urlSlugController);
        //var_dump($this->urlSlugController);
        //Converter a primeira letra de cada palavra em maisculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        //var_dump($this->urlSlugController);
        //Retirar espaço em branco
        $this->urlSlugController = str_replace(" ","", $this->urlSlugController);

        //var_dump($this->urlSlugController);
        return $this->urlSlugController;
    }

    /**
     * Tratar o método
     * Instanciar o método que trata a controller
     * Converter a primeira letra para minusculo
     * 
     * @param [type] $urlslugMetodo
     * @return string
     */
    private function slugMetodo($urlSlugMetodo): string 
    {   
        $this->urlSlugMetodo =  $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }

    /**
     * Carregar as Controllers
     * Instanciar as classes da controller e carregar o método
     * 
     * @return void
     */
    public function loadPage() :void
    {
        //echo "Carregar Pagina<br>"; 
        /*$this->urlController = ucwords($this->urlController);*/
        
        //$this->classLoad = "\\App\\adms\\Controllers\\". $this->urlController;
        //$classePage = new $this->classLoad();
        //$classePage->{$this->urlMetodo}();

        $loadPgAdm = new \Core\CarregarPg();
        $loadPgAdm->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);

    }
}
