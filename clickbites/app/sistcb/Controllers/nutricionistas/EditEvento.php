<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class EditEvento
{
    private int $idSala;
    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    public function index(): void
    {
        $this->idSala = filter_input(INPUT_GET, "idSala", FILTER_DEFAULT);
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $idCardapio = $this->dataForm['id'];
        
        if ((!empty($this->idSala)) and (!empty($this->dataForm))) {
        
            $data_start = str_replace('/', '-', $this->dataForm['start']);
            $data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
            $this->dataForm['start'] = $data_start_conv;

            $data_end = str_replace('/', '-', $this->dataForm['end']);
            $data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
            $this->dataForm['end'] = $data_end_conv;
            

            $updateEvento = new \App\sistcb\Models\helper\SistcbUpdate();
            $updateEvento->exeUpdate("cardapios", $this->dataForm, "WHERE id=:id", "id={$idCardapio}");

            $_SESSION['msg'] = "<p class='alert-success'>Evento Editado com sucesso!</p>";
            $urlRedirect = URLADM . "calendario-interativo/index?id=$this->idSala";
            header("Location: $urlRedirect");
        }else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
        
    }

}
