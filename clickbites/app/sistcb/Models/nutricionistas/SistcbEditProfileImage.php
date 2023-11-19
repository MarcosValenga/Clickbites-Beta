<?php

namespace App\sistcb\Models\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a imagem do perfil do usuario no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbEditProfileImage
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataImagem Recebe os dados da imagem */
    private array|null $dataImage;

    /** @var string $directory Recebe o endereço de upload da imagem */
    private string $directory;

    /** @var string $delImg Recebe o endereço da imagem que deve ser excluida */
    private string $delImg;
    /** @var string $nameImg Recebe o slug/nome da imagem */
    private string $nameImg;

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

    public function viewProfile(): bool
    {
        $viewUser = new \App\sistcb\Models\helper\SistcbRead();
        $viewUser->fullRead(
            "SELECT id, imagem
            FROM nutricionistas
            WHERE id = :id 
            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );


        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
            return false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataImage = $this->data['new_image'];
        unset($this->data['new_image']);

        $valEmptyField = new \App\sistcb\Models\helper\SistcbValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImage['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** 
     * Verificar se existe o usuário com ID logado
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valExtImg = new \App\sistcb\Models\helper\SistcbValExtImg();
        var_dump( $valExtImg);
        $valExtImg->validateExtImg($this->dataImage['type']);
        var_dump( $valExtImg);

        if ($this->viewProfile($valExtImg->getResult())) {
            $this->result = true;
            $this->upload();
        } else {
            $this->result = false;
        }
    }

    private function upload(): void
    {
        $slugImg = new \App\sistcb\Models\helper\SistcbSlug();
        $this->nameImg = $slugImg->slug($this->dataImage['name']);

        $this->directory = "app/sistcb/assets/image/users/" . $_SESSION['user_tipo'] . "/" . $_SESSION['user_id'] . "/";
        var_dump($this->directory);
        //$uploadImg = new \App\sistcb\Models\helper\sistcbUpload();
        //$uploadImg->upload($this->directory, $this->dataImage['tmp_name'], $this->nameImg);

        $uploadImgRes = new \App\sistcb\Models\helper\SistcbUploadImgRes();
        $uploadImgRes->upload($this->dataImage, $this->directory, $this->nameImg, 300, 300);

        if (($uploadImgRes->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['imagem'] =  $this->nameImg;
        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\sistcb\Models\helper\SistcbUpdate();
        $upUser->exeUpdate("nutricionistas", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);

        if ($upUser->getResult()) {
            $_SESSION['user_imagem'] = $this->nameImg;
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Imagem não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    private function deleteImage(): void
    {
        $image = $this->resultBd[0]['imagem'] ?? null;
        $this->delImg = "app/sistcb/assets/image/users/" . $_SESSION['user_tipo'] . "/" . $_SESSION['user_id'] . "/$image";

        //var_dump($this->delImg); // Adicione esta linha para depuração

        if ($image !== null && file_exists($this->delImg) && is_file($this->delImg)) {
            unlink($this->delImg);
        }
        $_SESSION['msg'] = "<p class='alert-success'>Imagem editada com sucesso!</p>";
        $this->result = true;
    }
}
