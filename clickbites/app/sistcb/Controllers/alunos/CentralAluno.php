<?php

namespace App\sistcb\Controllers\alunos;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página Dashboard
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class CentralAluno
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array|string|null $data;

    /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index():void
    {

        $this->data['sidebarActive'] = "centralAluno";
        //var_dump($this->data);
        $loadView = new \Core\ConfigView("sistcb/Views/alunos/centralAluno", $this->data);
        $loadView->loadViewAluno();
        //var_dump($loadView);
    }
}