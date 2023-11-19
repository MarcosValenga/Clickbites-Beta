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
class SistcbDesvincularSala
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;


    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Metodo recebe como parametro o ID que será usado para excluir o registro da tabela adms_users
     * Chama a função viewUser para verificar se o usuário esta cadastrado no sistema e na sequencia chama a função deleteImg para apagar a imagem do usuário
     * @param integer $id
     * @return void
     */
    public function desvincularSala(): void
    {
    
        if ($this->viewUser()) {
            if (!empty($this->resultBd[0]['fk_sala_id'])) {
                $desSala = new \App\sistcb\Models\helper\SistcbUpdate();
                $desSala->exeUpdate(
                    "alunos",
                    ['fk_sala_id' => null, 'modified' => date("Y-m-d H:i:s")],
                    "WHERE id = :id",
                    "id=".$_SESSION['user_id']
                );
    
                if ($desSala->getResult()) {
                    $_SESSION['msg'] = "<p class='alert-success'>Você foi desvinculado da sala com sucesso!</p>";
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Não foi possível desvincular da sala. Por favor, tente novamente mais tarde.</p>";
                    $this->result = false;
                }
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Você não possui nenhum vínculo atual!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    

    /**
     * Metodo faz a pesquisa para verificar se o usuário esta cadastrado no sistema, o resultado é enviado para a função deleteUser
     *
     * @return boolean
     */
    private function viewUser(): bool
    {

        $viewCheck = new \App\sistcb\Models\helper\SistcbRead();
        $viewCheck->fullRead(
            "SELECT fk_sala_id
                    FROM alunos                           
                    WHERE id=:id
                    LIMIT :limit",
            "id=".$_SESSION['user_id']."&limit=1"
        );

        $this->resultBd = $viewCheck->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Você não possui nenhum vinculo atual!</p>";
            return false;
        }
    }
}

