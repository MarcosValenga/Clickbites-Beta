<?php

namespace App\sistcb\Models\alunos;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o perfil do usuario no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbEditProfile
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewProfile(): void
    {
        $viewUser = new \App\sistcb\Models\helper\SistcbRead();            
        $viewUser->fullRead(
            "SELECT id, nome, email, user
            FROM alunos
            WHERE id = :id 
            LIMIT :limit",
            "id=".$_SESSION['user_id']."&limit=1"
        );
             
        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\sistcb\Models\helper\SistcbValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    private function valInput(): void
    {
        $valEmail = new \App\sistcb\Models\helper\SistcbValEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\sistcb\Models\helper\SistcbValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $_SESSION['user_id']);

        $valUserSingle = new \App\sistcb\Models\helper\SistcbValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $_SESSION['user_id']);

        if (($valEmail->getResult()) && ($valEmailSingle->getResult() && $valUserSingle->getResult())) {
            $this->edit();
         } else {
            $this->result = false;
         }
    }

    private function edit(): void
    {   
        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\sistcb\Models\helper\SistcbUpdate();
        $upUser->exeUpdate("alunos", $this->data, "WHERE id=:id", "id=". $_SESSION['user_id']);

        if($upUser->getResult()){
            $_SESSION['user_nome'] = $this->data['nome'];
            $_SESSION['user_email'] = $this->data['email'];
            $_SESSION['msg'] = "<p class='alert-success'>Perfil editado com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}

