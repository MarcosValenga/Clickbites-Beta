<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class DeleteEvento
{
    private int $idEvent;
    private int $idSala;

    public function index(): void
    {
        $this->idEvent = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $this->idSala = filter_input(INPUT_GET, "idSala", FILTER_VALIDATE_INT);
        
        if (!empty($this->idEvent)) {
            $deleteUser = new \App\sistcb\Models\nutricionistas\SistcbDeleteEvento();
            $deleteUser->deleteEvento($this->idEvent); 
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }

        $urlRedirect = URLADM . "calendario-interativo/index?id=$this->idSala";
        header("Location: $urlRedirect");
    }


}
