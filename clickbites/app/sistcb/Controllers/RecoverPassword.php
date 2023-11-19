<?php

namespace App\sistcb\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página recuperar senha
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class RecoverPassword
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
        if (!empty($this->dataForm['SendRecoverPass'])) {
            unset($this->dataForm['SendRecoverPass']);
            $recoverPass = new \App\sistcb\Models\SistcbRecoverPassword();
            $recoverPass->recoverPassword($this->dataForm);

            if ($recoverPass->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] =  $this->dataForm;
                $this->viewRecoverPass();
            }
        } else {
            $this->viewRecoverPass();
        }
    }

    private function viewRecoverPass(): void
    {
        $loadView = new \Core\ConfigView("sistcb/Views/login/recoverPassword", $this->data);
        $loadView->loadViewLogin();
    }
}
