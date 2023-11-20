<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class AddEvento
{
    private int $idSala;
    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    public function index(): void
    {
        $this->idSala = filter_input(INPUT_GET, "idSala", FILTER_DEFAULT);
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if ((!empty($this->idSala)) and (!empty($this->dataForm))) {
            $this->dataForm['fk_sala_id'] = $this->idSala;
        
            $data_start = str_replace('/', '-', $this->dataForm['start']);
            $data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
            $this->dataForm['start'] = $data_start_conv;

            $data_end = str_replace('/', '-', $this->dataForm['end']);
            $data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
            $this->dataForm['end'] = $data_end_conv;
            

            $createEvento = new \App\sistcb\Models\helper\SistcbCreate();
            $createEvento->exeCreate("cardapios", $this->dataForm);
        

            $urlRedirect = URLADM . "calendario-interativo/index?id=$this->idSala";
            header("Location: $urlRedirect");
        }else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
        
        
        
    }

}
