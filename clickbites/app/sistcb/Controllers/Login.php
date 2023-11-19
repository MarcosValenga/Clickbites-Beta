<?php

namespace App\sistcb\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página login
 * @author  Marcos Valenga <marcosvalenga360@gmail.com>
 */
class Login
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendLogin'])){
            $valLogin = new \App\sistcb\Models\SistcbLogin();
            $valLogin->login($this->dataForm);
            $tipo_usr = $_SESSION['user_tipo'];
            if(($valLogin->getResult()) and ($tipo_usr === 'aluno')){
                $urlRedirect = URLADM . "central-aluno/index";
                header("Location: $urlRedirect");
            }elseif (($valLogin->getResult()) and ($tipo_usr === 'nutricionista')){
                $urlRedirect = URLADM . "central-nutricionista/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
            }
           
        }

        //$this->data = null;

        $loadView = new \Core\ConfigView("sistcb/Views/login/login", $this->data);
        $loadView->loadViewLogin();
    }
}
