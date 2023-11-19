<?php

namespace App\sistcb\Models\nutricionistas;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbViewProfile
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
            "SELECT nome, email, user, imagem, certificado_nut
            FROM nutricionistas 
            WHERE id = :id 
            LIMIT :limit",
            "id=".$_SESSION['user_id']."&limit=1"
        );
            
     
        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }
    }
}

