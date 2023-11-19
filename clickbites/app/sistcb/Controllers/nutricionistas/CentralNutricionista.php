<?php

namespace App\sistcb\Controllers\nutricionistas;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página Central Nutricionista
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class CentralNutricionista
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array|string|null $data;

    /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index():void
    {
        $this->data['sidebarActive'] = "dashboard";

        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/centralNutricionista", $this->data);
        $loadView->loadViewNutricionista();
    }
}