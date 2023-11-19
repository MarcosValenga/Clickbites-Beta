<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para validar se os campos estão preenchidos
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbValEmptyField
{
    /** @var array|null $data Recebe o array de dados que deve ser validado */
    private array|null $data;

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
     * Validar se todos os campos estão preenchidos.
     * Recebe o array de dados que deve ser validado.
     * Retorna TRUE quando todos os campos estão preenchidos.
     * Retorna FALSE quando algum campo está vazio.
     * 
     * @param array $data Recebe o array de dados que deve ser validado.
     * 
     * @return void
     */
    public function valField(array $data = null): void
    {
        $this->data = $data;
        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);

        if(in_array('', $this->data)){
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário preencher todos os campos!</p>";
            $this->result = false;
        }else{
            $this->result = true;
        }
    }
}
