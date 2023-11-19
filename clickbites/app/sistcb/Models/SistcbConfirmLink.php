<?php

namespace App\sistcb\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}


/**
 * Confirmar o cadastro do usuário, alterando a situação no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbConfirmLink
{

    /** @var string $key Recebe a chave para confirmar o cadastro */
    private string $key;

    private string $tipo_usr;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    private array $dataSave;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * 
     * @return void
     */
    public function confLink(string $key): void
    {
        $this->key = $key;

        if ($_SESSION['user_tipo'] === 'aluno'){
            $this->tipo_usr = 'alunos';
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Faça login como aluno e acesse o link novamente para entrar na sala!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
        
        // Verifica se já existe um valor em fk_sala_id para o aluno
        if ($this->valExistVinculo()){
            if (!empty($this->key)) {
                $viewKeyConfLink = new \App\sistcb\Models\helper\SistcbRead();
                $viewKeyConfLink->fullRead("SELECT id 
                                            FROM salas
                                            WHERE uniqid_acesso =:uniqid_acesso 
                                            LIMIT :limit", "uniqid_acesso={$this->key}&limit=1");
                $this->resultBd = $viewKeyConfLink->getResult();
                if ($this->resultBd) {
                    $this->updateSitUser();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro 2</p>";
                    $this->result = false;
                }
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro 3</p>";
                $this->result = false;
            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Você já está vinculado a uma sala. Para desvincular, acesse as configurações.</p>";
            $this->result = false;
        }
    }

    private function updateSitUser(): void
    {
        $this->dataSave['fk_sala_id'] = $this->resultBd[0]['id'];
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upConfLink = new \App\sistcb\Models\helper\SistcbUpdate();
        $upConfLink->exeUpdate($this->tipo_usr, $this->dataSave, "WHERE id=:id", "id=".$_SESSION['user_id']);

        if ($upConfLink->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Bem-vindo à sala! Sua entrada foi um sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Ops! Parece que algo deu errado ao tentar entrar na sala. Por favor, tente novamente mais tarde. Se o problema persistir, entre em contato conosco para que possamos ajudar a resolver isso.";
            $this->result = false;
        }
    }


    private function valExistVinculo(): bool
    {   
        $read = new \App\sistcb\Models\helper\SistcbRead();
        $read->fullRead("SELECT fk_sala_id FROM ($this->tipo_usr) WHERE id = :id", "id=".$_SESSION['user_id']);
    
        $result = $read->getResult();
        if (!empty($result[0]['fk_sala_id'])) {
            return false;
        }else{
            return true;  
        }
    
        
    }
    
}
