<?php

namespace App\sistcb\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Solicitar novo link para cadastrar nova senha
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbRecoverPassword
{

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;

    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail = EMAILADM;

    private array $dataSave;

    private string $url;

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
    public function recoverPassword(array $data = null): void
    {
        $this->data = $data;
        $valEmptyField = new \App\sistcb\Models\helper\SistcbValEmptyField();
        $valEmptyField->valField($this->data);
        if($valEmptyField->getResult()){
            $this->valUser();
        }else{
            $this->result = false;
        }
    }

    private function valUser(): void
    {
        $newConfEmail = new \App\sistcb\Models\helper\SistcbRead();
        $newConfEmail->fullRead("(SELECT id, nome, email, 'nutricionistas' AS tipo_usr FROM nutricionistas WHERE email=:email LIMIT :limit)
                                UNION
                                (SELECT id, nome, email, 'alunos' AS tipo_usr FROM alunos WHERE email=:email LIMIT :limit)",
                                "email={$this->data['email']}&limit=1"   
        );
        $this->resultBd = $newConfEmail->getResult();
        if ($this->resultBd) {
            $tipo_usr = $this->resultBd[0]['tipo_usr'];
            $this->valConfEmail($tipo_usr);
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail não cadastrado!</p>";
            $this->result = false;
        }
    }

    private function valConfEmail($tipo_usr): void
    {
        $this->dataSave['recover_password'] = password_hash(date("Y-m-d H:i:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);            
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upNewConfEmail = new \App\sistcb\Models\helper\SistcbUpdate();
        //var_dump($this->resultBd);
        $upNewConfEmail->exeUpdate($tipo_usr, $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");
        if($upNewConfEmail->getResult()){
            $this->resultBd[0]['recover_password'] = $this->dataSave['recover_password'];
            $this->sendEmail($tipo_usr);
        }else{

            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Link não enviado, tente novamente!</p>";
            $this->result = false;
        }
    }

    private function sendEmail($tipo_usr): void
    {
        $sendEmail = new \App\sistcb\Models\helper\SistcbSendEmail();
        $this->emailHTML($tipo_usr);
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 1);
        if ($sendEmail->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail com as intruções para recuperar a senha não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML($tipo_usr): void
    {
        $nome = explode(" ", $this->resultBd[0]['nome']);
        $this->firstName = $nome[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->resultBd[0]['nome'];
        $this->emailData['subject'] = "Recuperar senha";
        $this->url = URLADM . "update-password/index?key=" . $this->resultBd[0]['recover_password'] . "&tipo_usr=" . $tipo_usr;;

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Você solicitou alteração de senha.<br><br>";
        $this->emailData['contentHtml'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='" . $this->url . "'>" . $this->url . "</a><br><br>";
        $this->emailData['contentHtml'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Você solicitou alteração de senha.\n\n";
        $this->emailData['contentText'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";
    }
}
