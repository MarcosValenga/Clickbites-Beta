<?php

namespace App\sistcb\Models\nutricionistas;
use chillerlan\QRCode\QROptions;



class SistcbAddSala
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    function getResult(): bool
    {
        return $this->result;
    }

    public function create(array $data = null)
    {
        $this->data = $data;
    
        $valEmptyField = new \App\sistcb\Models\helper\SistcbValEmptyField();
        $valEmptyField->valField($this->data);
        
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }
    
    private function add(): void
    {
        // Insere os dados da sala no banco de dados
        $this->data['fk_nutricionista_id'] = $_SESSION['user_id'];
	    $this->data['created'] = date("Y-m-d H:i:s");	


        $createUser = new \App\sistcb\Models\helper\SistcbCreate();
        $createUser->exeCreate("salas", $this->data);
        
        if ($createUser->getResult()) {
            // Obtém o ID recém-inserido
            $idSala = $createUser->getResult();
            $iduniq = uniqid($idSala); 

            $updateUniqid = new \App\sistcb\Models\helper\SistcbUpdate();
            $updateUniqid->exeUpdate(
                "salas",
                ['uniqid_acesso' => $iduniq],
                "WHERE id = :id",
                "id={$idSala}"
            );
            
            // Gera o link e QRCode usando o ID da sala
            $confirm_link = URLADM . "confirm-link/index?key=$iduniq";
            $qrcode_acesso = $this->generateQRCode($confirm_link, $idSala);
    
            // Atualiza os dados da sala com o link e QRCode
            $updateSala = new \App\sistcb\Models\helper\SistcbUpdate();
            $updateSala->exeUpdate(
                "salas",
                ['link_acesso' => $confirm_link, 'qrcode_acesso' => $qrcode_acesso],
                "WHERE id = :id",
                "id={$idSala}"
            );
    
            if ($updateSala->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Sala adicionada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sala não adicionada com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sala não adicionada com sucesso!</p>";
            $this->result = false;
        }
    }
    

    private function generateQRCode(string $confirm_link, string $idSala): string
    {
        $options= new QROptions([
            // Número da versão do código QRCode
            'version'     => 7,
            // Alterar para base64
            'imageBase64' => true,
            // escala da imagem
            'scale'       => 7
        ]);

        $qrcode = (new \chillerlan\QRCode\QRCode($options))->render($confirm_link);

        $imagem = str_replace('data:image/png;base64,', '', $qrcode);

        $arquivo_imagem = base64_decode($imagem);

        // Crie o caminho para salvar o QRCode dentro do diretório temporário
        $path = "app/sistcb/assets/qrcodes/nutricionista/" . $_SESSION['user_id'] . "/salas/$idSala/qrcode.png";
    
        // Garanta que o diretório de destino exista
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    
        // Salve o QRCode no arquivo
        if (file_put_contents($path, $arquivo_imagem)) {
            echo "<p style='color: green;'>Upload realizado com sucesso!</p>";
        } else {
            echo "<p style='color: #f00;'>Erro: Upload não realizado com sucesso!</p>";
        }
        return $path;
    }
    
}       
 



