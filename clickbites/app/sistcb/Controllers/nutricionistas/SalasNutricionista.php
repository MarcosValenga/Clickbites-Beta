<?php

namespace App\sistcb\Controllers\nutricionistas;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar perfil
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class SalasNutricionista
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array $data;

    /** @var array|string|null $page Recebe o número da página*/
    private string|int|null $page;

     /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     * @return void
     */
    public function index(string|int|null $page = null): void
    {   
        $this->page = (int) $page ? $page : 1;

        $listSalas = new \App\sistcb\Models\nutricionistas\SistcbSalasNutricionista();
        $listSalas->listSalas($this->page);
        if($listSalas->getResult()){
            $this->data['listSalas'] = $listSalas->getResultBd();
            $this->data['pagination'] = $listSalas->getResultPg();
        }else{
            $this->data['listSalas'] = [];
            $this->data['pagination'] = "";

        }
        

        $this->data['sidebarActive'] = "dashboard";
        

        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/salasNutricionista", $this->data);
        $loadView->loadViewNutricionista();
    }
    
}