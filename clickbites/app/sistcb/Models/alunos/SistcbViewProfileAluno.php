<?php

namespace App\sistcb\Models\alunos;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbViewProfileAluno
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
            "SELECT al.nome, al.email, al.user, al.imagem, sl.nome_sala
            FROM alunos as al
            LEFT JOIN salas as sl ON al.fk_sala_id = sl.id
            WHERE al.id = :id
            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );


        $this->resultBd = $viewUser->getResult();
        //var_dump($this->resultBd);
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }
    }
}

