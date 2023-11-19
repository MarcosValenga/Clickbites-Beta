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
class ConfEmail
{

    /** @var string|null $key Recebe a chave para confirmar o cadastro */
    private string|null $key;

    private string $tipo_usr;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);
        $this->tipo_usr = filter_input(INPUT_GET, "tipo_usr", FILTER_DEFAULT);

        if (!empty($this->key) and !empty($this->tipo_usr)) {
            $this->valKey();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro1: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valKey(): void
    {
        $confEmail = new \App\sistcb\Models\SistcbConfEmail();
        $confEmail->confEmail($this->key, $this->tipo_usr);
        if ($confEmail->getResult()) {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
