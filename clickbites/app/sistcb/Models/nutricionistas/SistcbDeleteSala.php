<?php

namespace App\sistcb\Models\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar o usuário no banco de dados
 *
 * @author Celke
 */
class SistcbDeleteSala
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $delDirectory Recebe o endereço para apagar o diretório */
    private string $delDirectory;

    /** @var string $delImg Recebe o endereço para apagar a imagem */
    private string $delImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Metodo recebe como parametro o ID que será usado para excluir o registro da tabela adms_users
     * Chama a função viewUser para verificar se o usuário esta cadastrado no sistema e na sequencia chama a função deleteImg para apagar a imagem do usuário
     * @param integer $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewUser()) {
            $deleteUser = new \App\sistcb\Models\helper\SistcbDelete();
            $deleteUser->exeDelete("salas", "WHERE id =:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg($id);
                $_SESSION['msg'] = "<p class='alert-success'>Sala apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não apagado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo faz a pesquisa para verificar se o usuário esta cadastrado no sistema, o resultado é enviado para a função deleteUser
     *
     * @return boolean
     */
    private function viewUser(): bool
    {

        $viewUser = new \App\sistcb\Models\helper\SistcbRead();
        $viewUser->fullRead(
            "SELECT id, qrcode_acesso
                    FROM salas                           
                    WHERE id=:id
                    LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            return false;
        }
    }

    /**
     * Metodo usado para apagar a imagem e o diretorio do usuário do servidor
     *
     * @return void
     */
    private function deleteImg(int $id): void
    {
        $qrcodePath = "app/sistcb/assets/qrcodes/nutricionista/" . $_SESSION['user_id'] . "/salas/{$id}/qrcode.png";
        $directoryPath = "app/sistcb/assets/qrcodes/nutricionista/" . $_SESSION['user_id'] . "/salas/{$id}";
    
        // Verifica se o arquivo QRCode existe e o exclui
        if (file_exists($qrcodePath)) {
            unlink($qrcodePath);
        }
    
        // Verifica se o diretório existe e o exclui
        if (is_dir($directoryPath)) {
            rmdir($directoryPath);
        }
    }
}
