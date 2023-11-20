<?php
namespace Core;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class CarregarPg
{
    private string $urlController;
    private string $urlMetodo;
    private string $urlParameter;
    private string $classLoad;
    private string $urlSlugController;
    private string $urlSlugMetodo;
    private array $listPgPublic;
    private array $listPgAlunos;
    private array $listPgNutricionistas;

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
            $this->urlController = $this->slugController(CONTROLLER);
            //var_dump($this->urlController);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
            $this->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
        }
    }

    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();
        //var_dump($classLoad);
        if (method_exists($classLoad, $this->urlMetodo)) {
            $classLoad->{$this->urlMetodo}($this->urlParameter);
            //var_dump($classLoad);
        } else {
            die("Erro - 0021: Por favor, tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);
        }
    }

    private function pgPublic(): void
    {
        $this->listPgPublic = ["Login", "Erro", "Logout", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword", "ConfirmLink"];

        if (in_array($this->urlController, $this->listPgPublic)) {
            $this->classLoad = "\\App\\sistcb\\Controllers\\" . $this->urlController;
            $this->urlController;
        } else {
            $this->pgPrivateAlunos();
        }
    }

    private function pgPrivateAlunos(): void
    {
        $this->listPgAlunos = ["CentralAluno", "ViewProfileAluno", "EditProfileAluno", "DesvincularSala", "CalendarioView"];
        //var_dump($this->urlController);
        //var_dump($this->listPgAlunos);
        if(in_array($this->urlController, $this->listPgAlunos)){
            $this->verifyLogin();
        }else{
            $this->pgPrivateNutricionistas();
        }
    }

    private function pgPrivateNutricionistas(): void
    {
        $this->listPgNutricionistas = ["CentralNutricionista", "ViewProfile", "EditProfile", "EditProfileImage", "EditProfilePassword", "SalasNutricionista", "AddSala", "DeleteSala", "CalendarioInterativo", "DeleteEvento", "AddEvento", "EditEvento"];
        if(in_array($this->urlController, $this->listPgNutricionistas)){
            $this->verifyLogin();
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página não encontrada</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function verifyLogin(): void
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_nome']) && isset($_SESSION['user_email']) && isset($_SESSION['user_tipo'])) {
            // Lógica para verificar o tipo de usuário e conceder permissão
            // Exemplo: Aqui você pode adicionar condições para carregar diferentes controllers com base no tipo de usuário
            $userType = $_SESSION['user_tipo'];

            if ($userType === 'nutricionista') {
           
                if (in_array($this->urlController, $this->listPgNutricionistas)) {
                    $this->classLoad = "\\App\\sistcb\\Controllers\\nutricionistas\\" . $this->urlController;
                }
            } elseif ($userType === 'aluno') {
                //var_dump($this->listPgAlunos);
                if (in_array($this->urlController, $this->listPgAlunos))  {
                    $this->classLoad = "\\App\\sistcb\\Controllers\\alunos\\" . $this->urlController;
                    //var_dump($this->classLoad );

                }
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Para acessar a página, realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function slugController($slugController): string
    {
        $this->urlSlugController = $slugController;
        $this->urlSlugController = strtolower($this->urlSlugController);
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        $this->urlSlugController = ucwords($this->urlSlugController);
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);

        
        return $this->urlSlugController;
    }

    private function slugMetodo($urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);

        return $this->urlSlugMetodo;
    }
}

