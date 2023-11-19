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
class SistcbValUserSingle
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
    public function validateUserSingle(string $user, bool $edit = false, ?int $id = null): void
    {
        $this->user = $user;
        $this->edit = $edit;
        $this->id = $id;
    
        $valUserSingle = new \App\sistcb\Models\helper\SistcbRead();
    
        // Verificação para a tabela "alunos"
        $queryAlunosEmail = "SELECT id FROM alunos WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryAlunosEmail .= " AND id <> :id";
        }
        $queryAlunosEmail .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryAlunosEmail, "email={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAlunosEmail = $valUserSingle->getResult();
    
        $queryAlunosUser = "SELECT id FROM alunos WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryAlunosUser .= " AND id <> :id";
        }
        $queryAlunosUser .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryAlunosUser, "user={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAlunosUser = $valUserSingle->getResult();
    
        // Repita o processo para a tabela "nutricionistas" para as colunas "email" e "user"
        $queryNutricionistasEmail = "SELECT id FROM nutricionistas WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryNutricionistasEmail .= " AND id <> :id";
        }
        $queryNutricionistasEmail .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryNutricionistasEmail, "email={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultNutricionistasEmail = $valUserSingle->getResult();
    
        $queryNutricionistasUser = "SELECT id FROM nutricionistas WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryNutricionistasUser .= " AND id <> :id";
        }
        $queryNutricionistasUser .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryNutricionistasUser, "user={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultNutricionistasUser = $valUserSingle->getResult();
    
        // Repita o processo para a tabela "adms_users" para as colunas "email" e "user"
        $queryAdmsUsersEmail = "SELECT id FROM adms_users WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryAdmsUsersEmail .= " AND id <> :id";
        }
        $queryAdmsUsersEmail .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryAdmsUsersEmail, "email={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAdmsUsersEmail = $valUserSingle->getResult();
    
        $queryAdmsUsersUser = "SELECT id FROM adms_users WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryAdmsUsersUser .= " AND id <> :id";
        }
        $queryAdmsUsersUser .= " LIMIT 1";
    
        $valUserSingle->fullRead($queryAdmsUsersUser, "user={$this->user}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAdmsUsersUser = $valUserSingle->getResult();
    
        // Verifique os resultados das consultas e defina $this->result de acordo
        if (
            !$resultAlunosEmail && !$resultNutricionistasEmail && !$resultAdmsUsersEmail &&
            !$resultAlunosUser && !$resultNutricionistasUser && !$resultAdmsUsersUser
        ) {
            $this->result = true; // E-mail e usuário são únicos em todas as tabelas e colunas
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este e-mail ou usuário já está cadastrado!</p>";
            $this->result = false; // E-mail ou usuário já existe em pelo menos uma das tabelas ou colunas
        }
    }
    
    
}
