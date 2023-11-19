<?php

namespace App\sistcb\Controllers\alunos;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar perfil
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ViewProfileAluno
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array $data;

     /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index(): void
    {   
        
        $viewProfile = new \App\sistcb\Models\alunos\SistcbViewProfileAluno();
        $viewProfile->viewProfile();
        if ($viewProfile->getResult()) {
            $this->data['viewProfile'] = $viewProfile->getResultBd();
            $this->loadViewProfile();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Usuário não encontrado!</p>";
            //$urlRedirect = URLADM . "login/index";
            //header("Location: $urlRedirect");
        }

        
        
    }
    

    private function loadViewProfile(): void
    {
        $loadView = new \Core\ConfigView("sistcb/Views/alunos/viewProfileAluno", $this->data);
        $loadView->loadViewAluno();
    }
}