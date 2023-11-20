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
class SistcbDeleteEvento
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
    public function deleteEvento(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewUser()) {
            $deleteEvento = new \App\sistcb\Models\helper\SistcbDelete();
            $deleteEvento->exeDelete("cardapios", "WHERE id =:id", "id={$this->id}");

            if ($deleteEvento->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Evento apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Evento não apagado com sucesso!</p>";
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
            "SELECT id
                    FROM cardapios                           
                    WHERE id=:id
                    LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Evento não encontrado!</p>";
            return false;
        }
    }

}
