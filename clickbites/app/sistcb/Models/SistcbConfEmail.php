<?php

namespace App\sistcb\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use App\sistcb\Models\helper\SistcbConn;
use PDO;

/**
 * Confirmar o cadastro do usuário, alterando a situação no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbConfEmail extends SistcbConn
{

    /** @var string $key Recebe a chave para confirmar o cadastro */
    private string $key;

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
    public function confEmail(string $key, string $tipo_usr): void
    {
        $this->key = $key;

        if (!empty($this->key)) {
            $viewKeyConfEmail = new \App\sistcb\Models\helper\SistcbRead();
            $viewKeyConfEmail->fullRead("SELECT id 
                                        FROM ($tipo_usr)
                                        WHERE conf_email =:conf_email 
                                        LIMIT :limit", "conf_email={$this->key}&limit=1");
            $this->resultBd = $viewKeyConfEmail->getResult();
            if ($this->resultBd) {
                $this->updateSitUser($tipo_usr);
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro2: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro3: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        }
    }

    private function updateSitUser(string $tipo_usr): void
    {
        $this->dataSave['conf_email'] = null;
        $this->dataSave['fk_sits_usuario'] = 1;
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upConfEmail = new \App\sistcb\Models\helper\SistcbUpdate();
        $upConfEmail->exeUpdate($tipo_usr, $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($upConfEmail->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>E-mail ativado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro4: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        }
    }
}

