<?php

namespace App\sistcb\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página Confirmar Email
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class ConfirmLink
{

    /** @var string|null $key Recebe a chave para confirmar o cadastro */
    private string|null $key;


    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);
        if (!empty($this->key)) {
            $this->valKey();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valKey(): void
    {
        $confLink = new \App\sistcb\Models\SistcbConfirmLink();
        $confLink->confLink($this->key);
        if ($confLink->getResult()) {
            $urlRedirect = URLADM . "central-aluno/index";
            header("Location: $urlRedirect");
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
