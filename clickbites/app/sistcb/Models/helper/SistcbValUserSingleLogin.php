<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genêrica para validar o usuário único, somente um cadatrado pode utilizar o usuário
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbValUserSingleLogin
{
    /** @var string $user Recebe o usuário que deve ser validado */
    private string $user;

    /** @var bool|null $edit Recebe a informação que é utilizada para verificar se é para validar usuário para cadastro ou edição */
    private bool|null $edit;

    /** @var int|null $id Recebe o id do usuário que deve ser ignorado quando estiver validando o usuário para edição */
    private int|null $id;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }
    
    /** 
     * Validar o usuário único.
     * Recebe o usuário que deve ser verificado se o mesmo já está cadastrado no banco de dados.
     * Acessa o IF quando estiver validando o usuário para o formulário editar.
     * Acessa o ELSE quando estiver validando o usuário para o formulário cadastrar.
     * Retorna TRUE quando não encontrar outro nenhum usuário utilizando o usuário em questão.
     * Retorna FALSE quando o usuário já está sendo utilizado por outro usuário.
     * 
     * @param string $usuário Recebe o usuário que deve ser validado.
     * @param bool|null $edit Recebe TRUE quando deve validar o usuário para formulário editar.
     * @param int|null $id Recebe o ID do usuário quando deve validar o usuário para formulário editar.
     * 
     * @return void
     */
    public function validateUserSingleLogin(string $user, bool $edit = false, ?int $id = null): void
    {
        $this->user = $user;
        $this->edit = $edit;
        $this->id = $id;

        $valUserSingle = new \App\sistcb\Models\helper\SistcbRead();

        $userParam = $edit && $this->id !== null ? $this->user : $this->user;

        $queryAlunos = "SELECT id FROM alunos WHERE user = :user" . ($edit && $this->id !== null ? " AND id <> :id" : "") . " LIMIT 1";
        $valUserSingle->fullRead($queryAlunos, "user={$userParam}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAlunos = $valUserSingle->getResult();
        
        $queryNutricionistas = "SELECT id FROM nutricionistas WHERE user = :user" . ($edit && $this->id !== null ? " AND id <> :id" : "") . " LIMIT 1";
        $valUserSingle->fullRead($queryNutricionistas, "user={$userParam}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultNutricionistas = $valUserSingle->getResult();
        
        $queryAdmsUsers = "SELECT id FROM adms_users WHERE user = :user" . ($edit && $this->id !== null ? " AND id <> :id" : "") . " LIMIT 1";
        $valUserSingle->fullRead($queryAdmsUsers, "user={$userParam}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAdmsUsers = $valUserSingle->getResult();
        
        
        if(!$resultAlunos && !$resultNutricionistas && !$resultAdmsUsers){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este e-mail ou usuário já está cadastrado!</p>";
            $this->result = false;
        }
    }
}
