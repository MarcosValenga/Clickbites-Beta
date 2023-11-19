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
        var_dump($this->dataForm);
        if (!empty($this->idSala)) {
            var_dump("passou aqui");
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
        var_dump("passou aqui");
        if ($valSalaCalendar->getResult()){
            var_dump("Passou aqui");

            $this->data['event'] = $valSalaCalendar->getResultBd();
            var_dump( $this->data['event']);
        } else {
            var_dump("passou aqui");
            $this->data['event'] = [];
        }
        

        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/calendarioInterativo", $this->data);
        $loadView->loadViewNutricionista();
        
    }

    public function addEvent(): void
    {

    }
}
