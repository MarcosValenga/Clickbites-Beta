<?php

namespace App\sistcb\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página sair
 * @author  Marcos Valenga <marcosvalenga360@gmail.com>
 */
class Logout
{

    
    /**
     * Destruir as sessões do usuário logado
     * 
     * @return void
     */
    public function index():void
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_imagem'], $_SESSION['user_tipo'], $_SESSION['user_vinculo']);
        $_SESSION['msg'] = "<p class='alert-success'>Logout realizado com sucesso!</p>";
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
    }
}