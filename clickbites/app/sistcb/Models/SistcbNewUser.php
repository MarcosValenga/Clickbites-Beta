<?php

namespace App\sistcb\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}


/**
 * Cadastrar o usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbNewUser
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail;

    /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;

    /** @var string $url Recebe a URL com endereço para o usuário confirmar o e-mail */
    private string $url;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        $valEmptyField = new \App\sistcb\Models\helper\SistcbValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput(); // Remova o parâmetro da função
        } else {
            $this->result = false;
        }
    }
    
    /** 
     * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
     * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
     * Instanciar o helper "validatePassword" para validar a senha
     * Instanciar o helper "validateUserSingleLogin" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "add" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valEmail = new \App\sistcb\Models\helper\SistcbValEmail();
        $valEmail->validateEmail($this->data['email']);
    
        $valEmailSingle = new \App\sistcb\Models\helper\SistcbValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);
    
        $valPassword = new \App\sistcb\Models\helper\SistcbValPassword();
        $valPassword->validatePassword($this->data['password']);
    
        $valUserSingleLogin = new \App\sistcb\Models\helper\SistcbValUserSingleLogin();
        $valUserSingleLogin->validateUserSingleLogin($this->data['email']);
    
        if ($valEmail->getResult() && $valEmailSingle->getResult() && $valPassword->getResult() && $valUserSingleLogin->getResult()) {
            // Determine a tabela com base no tipo de usuário
            $table = "";
            if ($this->data['tipo_usr'] === 'aluno') {
                $table = "alunos";
            } elseif ($this->data['tipo_usr'] === 'nutricionista') {
                $table = "nutricionistas";
            }
            
            // Inserir dados na tabela determinada
            $this->add($table);
            
        } else {
            $this->result = false;
        }
    }
    
    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    private function add(string $table): void // Adicione o parâmetro $table
    {
        $tipo_usr = $this->data['tipo_usr'];
        unset($this->data['tipo_usr']);
    
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['user'] = $this->data['email'];
        $this->data['conf_email'] = password_hash($this->data['password'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        $this->data['created'] = date("Y-m-d H:i:s");

        //var_dump($table);

        $createUser = new \App\sistcb\Models\helper\SistcbCreate();
        $createUser->exeCreate($table, $this->data); // Use o valor de $table como o nome da tabela

        //var_dump($createUser);

        if ($createUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Usuário cadastrado com sucesso!</p>";
            $this->result = True;
            $this->sendEmail($table);
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }
    

    /**
     * Summary of sendEmail
     * @return void
     */
    private function sendEmail(string $table): void
    {

        $this->contentEmailHtml($table);
        $this->contentEmailText();

        $sendEmail = new \App\sistcb\Models\helper\SistcbSendEmail();
        $sendEmail->sendEmail($this->emailData, 1);

        if ($sendEmail->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Usuário cadastrado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p class='alert-info'>Usuário cadastrado com sucesso. Houve erro ao enviar o e-mail de confirmação, entre em contado com {$this->fromEmail} para mais informações!</p>";
            $this->result = true;
        }
    }

    private function contentEmailHtml(string $table): void
    {
        $nome = explode(" ", $this->data['nome']);
        $this->firstName = $nome[0];
    
        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->data['nome'];
        $this->emailData['subject'] = "Confirma sua conta";
    
        // Adicione informações sobre o tipo de usuário na URL
        $tipo_usr = $table;
        $this->url = URLADM . "conf-email/index?key=" . $this->data['conf_email'] . "&tipo_usr=" . $tipo_usr;
    
        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }
    

    private function contentEmailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .=  $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
