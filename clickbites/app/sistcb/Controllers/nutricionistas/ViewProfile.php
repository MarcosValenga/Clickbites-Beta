<?php

namespace App\sistcb\Controllers\nutricionistas;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar perfil
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ViewProfile
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array $data;

     /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index(): void
    {   
        
        $viewProfile = new \App\sistcb\Models\nutricionistas\SistcbViewProfile();
        $viewProfile->viewProfile();
        if ($viewProfile->getResult()) {
            $this->data['viewProfile'] = $viewProfile->getResultBd();
            $this->loadViewProfile();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }

        
        
    }
    

    private function loadViewProfile(): void
    {
        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/viewProfile", $this->data);
        $loadView->loadViewNutricionista();
    }
}