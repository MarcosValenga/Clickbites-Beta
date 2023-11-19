<?php

namespace App\sistcb\Models\alunos;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Pagina inicial do sistema administrativo "dashboard"
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbCentralAluno
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
        $this->result = true;

        return $this->result;
    }

    /**
     * @return array|null Retorna os dados
     */
    function getResultBd(): array|null
    {   
        return $this->resultBd;
    }


}

