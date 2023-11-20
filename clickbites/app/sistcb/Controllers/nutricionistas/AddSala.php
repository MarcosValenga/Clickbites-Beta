<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

class AddSala
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddSala'])) {
            unset($this->dataForm['SendAddSala']);
            $addSala = new \App\sistcb\Models\nutricionistas\SistcbAddSala();
            $addSala->create($this->dataForm);

            if ($addSala->getResult()) {
                $urlRedirect = URLADM . "salas-nutricionista/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSala();
            }
        } else {
            $this->viewAddSala();
        }
    }

    private function viewAddSala(): void
    {
        // Lógica para preencher campos SELECT ou outros dados necessários
        // ...

        $this->data['sidebarActive'] = "list-salas";

        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/addSala", $this->data);
        $loadView->loadViewNutricionista();
    }
}
