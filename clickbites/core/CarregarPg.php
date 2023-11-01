<?php

//require './core/Config.php';

namespace Core;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Verificar se existe a classe
 * Carregar a CONTROLLER
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class CarregarPg
{
    /** @var string $urlController recebe da URL o noma da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParameter Recebe da URL o parametro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;
    private array $listPgPublic;
    private array $listPgPrivate;

    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;

        //var_dump($this->urlController);
        //var_dump($this->urlMetodo);
        //var_dump($this->urlParameter);
        //unset($_SESSION['user_id']);

        $this->pgPublic();
        if (class_exists($this->classLoad)) {
            $this->loadMetodo();
        } else {
            //die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ". EMAILADM);
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
            $this->loadPage($this->urlController, $this->urlMetodo,  $this->urlParameter);
        }
    }

    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();
        if(method_exists($classLoad, $this->urlMetodo)){
            $classLoad->{$this->urlMetodo}($this->urlParameter);
        }else{
            die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ". EMAILADM);

        }
    }

    private function pgPublic():void
    {
        $this->listPgPublic = ["Login", "Erro", "Logout", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];

        if(in_array($this->urlController, $this->listPgPublic)){
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->urlController;
        }else{
            $this->pgPrivate();

        }
    }

    private function pgPrivate():void
    {
        $this->listPgPrivate = ["Dashboard", "ListUsers", "ViewUser", "AddUsers","EditUser", "DeleteUser", "EditUserPassword", "EditUserImage", "ViewProfile", "EditProfile", "EditProfilePassword", "EditProfileImage", "ListSitsUsers"];
        if(in_array($this->urlController, $this->listPgPrivate)){
            $this->verifyLogin();
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página não encontrada</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function verifyLogin(): void
    {
        if((isset($_SESSION['user_id'])) and (isset($_SESSION['user_nome'])) and
        (isset($_SESSION['user_email'])) )
        {
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
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
    private function slugController($slugController): string
    {
        $this->urlSlugController = $slugController;
        //Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        //Converter traço para espaço em branco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        //Converter a primeira letra de cada palavra em maisculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        //Retirar espaço em branco
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);

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
}
