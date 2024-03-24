<?php

namespace App\sistcb\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página novo usuário
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class NewUser
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsNewUser" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página a página de login.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
    */public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendNewUser'])) {
            unset($this->dataForm['SendNewUser']);

            $table = ""; // Determine dinamicamente o nome da tabela com base no tipo de usuário

            if (isset($this->dataForm['tipo_usr'])) {
                $tipo_usr = $this->dataForm['tipo_usr'];
                if ($tipo_usr === 'aluno') {
                    $table = "alunos";
                } elseif ($tipo_usr === 'nutricionista') {
                    $table = "nutricionistas";
                } 
            }

            $createNewUser = new \App\sistcb\Models\SistcbNewUser();
            $createNewUser->create($this->dataForm);

            if ($createNewUser->getResult()) {
                $urlRedirect = URLADM;
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewNewUser();
            }
        } else {
            $this->viewNewUser();
        }
    }


    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewNewUser(): void
    {
        $loadView = new \Core\ConfigView("sistcb/Views/login/login", $this->data);
        $loadView->loadViewLogin();
    }
}
