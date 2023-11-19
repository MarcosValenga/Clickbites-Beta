<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genêrica para validar o e-mail único, somente um cadatrado pode utilizar o e-mail
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbValEmailSingle
{
    /** @var string $email Recebe o e-mail que deve ser validado */
    private string $email;

    /** @var bool|null $edit Recebe a informação que é utilizada para verificar se é para validar e-mail para cadastro ou edição */
    private bool|null $edit;

    /** @var int|null $id Recebe o id do usuário que deve ser ignorado quando estiver validando o e-mail para edição */
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
     * Validar o e-mail único.
     * Recebe o e-mail que deve ser verificado se o mesmo já está cadastrado no banco de dados.
     * Acessa o IF quando estiver validando o e-mail para o formulário editar.
     * Acessa o ELSE quando estiver validando o e-mail para o formulário cadastrar.
     * Retorna TRUE quando não encontrar outro nenhum usuário utilizando o e-mail em questão.
     * Retorna FALSE quando o e-mail já está sendo utilizado por outro usuário.
     * 
     * @param string $email Recebe o e-mail que deve ser validado.
     * @param bool|null $edit Recebe TRUE quando deve validar o e-mail para formulário editar.
     * @param int|null $id Recebe o ID do usuário quando deve validar o e-mail para formulário editar.
     * 
     * @return void
     */
    public function validateEmailSingle(string $email, bool $edit = false, ?int $id = null): void
    {
        $this->email = $email;
        $this->edit = $edit;
        $this->id = $id;
    
        $valEmailSingle = new SistcbRead();
    
        // Verificação para a tabela "alunos"
        $queryAlunosEmail = "SELECT id FROM alunos WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryAlunosEmail .= " AND id <> :id";
        }
        $queryAlunosEmail .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryAlunosEmail, "email={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAlunosEmail = $valEmailSingle->getResult();
    
        $queryAlunosUser = "SELECT id FROM alunos WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryAlunosUser .= " AND id <> :id";
        }
        $queryAlunosUser .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryAlunosUser, "user={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAlunosUser = $valEmailSingle->getResult();
    
        // Repita o processo para a tabela "nutricionistas" para as colunas "email" e "user"
        $queryNutricionistasEmail = "SELECT id FROM nutricionistas WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryNutricionistasEmail .= " AND id <> :id";
        }
        $queryNutricionistasEmail .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryNutricionistasEmail, "email={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultNutricionistasEmail = $valEmailSingle->getResult();
    
        $queryNutricionistasUser = "SELECT id FROM nutricionistas WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryNutricionistasUser .= " AND id <> :id";
        }
        $queryNutricionistasUser .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryNutricionistasUser, "user={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultNutricionistasUser = $valEmailSingle->getResult();
    
        // Repita o processo para a tabela "adms_users" para as colunas "email" e "user"
        $queryAdmsUsersEmail = "SELECT id FROM adms_users WHERE email = :email";
        if ($edit && $this->id !== null) {
            $queryAdmsUsersEmail .= " AND id <> :id";
        }
        $queryAdmsUsersEmail .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryAdmsUsersEmail, "email={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAdmsUsersEmail = $valEmailSingle->getResult();
    
        $queryAdmsUsersUser = "SELECT id FROM adms_users WHERE user = :user";
        if ($edit && $this->id !== null) {
            $queryAdmsUsersUser .= " AND id <> :id";
        }
        $queryAdmsUsersUser .= " LIMIT 1";
    
        $valEmailSingle->fullRead($queryAdmsUsersUser, "user={$this->email}" . ($edit && $this->id !== null ? "&id={$this->id}" : ""));
        $resultAdmsUsersUser = $valEmailSingle->getResult();
    
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
