<?php

namespace App\sistcb\Controllers\alunos;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class CalendarioView
{
    private array $data;
    private int $idSala;

    public function index(): void
    {
        $this->idSala = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if (!empty($this->idSala)) {
            $this->valSalaCalendar();
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valSalaCalendar(): void
    {
        $valSalaCalendar = new \App\sistcb\Models\alunos\SistcbCalendarioView();
        $valSalaCalendar->obterEventos($this->idSala);

        if ($valSalaCalendar->getResult()){

            $this->data['event'] = $valSalaCalendar->getResultBd();
        } else {
            $this->data['event'] = [];
        }
        

        $loadView = new \Core\ConfigView("sistcb/Views/alunos/calendarioView", $this->data);
        $loadView->loadViewAluno();
        
    }
}
