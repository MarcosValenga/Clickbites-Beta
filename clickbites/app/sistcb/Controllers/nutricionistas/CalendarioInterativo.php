<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class CalendarioInterativo
{
    private array $data;
    private int $idSala;
    private array|null $dataForm;

    public function index(): void
    {
        $this->idSala = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->idSala)) {
            $this->valSalaCalendar();
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valSalaCalendar(): void
    {
        $valSalaCalendar = new \App\sistcb\Models\nutricionistas\SistcbCalendarioInterativo();
        $valSalaCalendar->obterEventos($this->idSala);

        if ($valSalaCalendar->getResult()){

            $this->data['event'] = $valSalaCalendar->getResultBd();
        } else {
            $this->data['event'] = [];
        }
        

        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/calendarioInterativo", $this->data);
        $loadView->loadViewNutricionista();
        
    }
}
