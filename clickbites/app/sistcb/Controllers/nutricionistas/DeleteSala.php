<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteSala
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Método apagar usuário
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar usuários
     *
     * @param integer|string|null|null $id
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteUser = new \App\sistcb\Models\nutricionistas\SistcbDeleteSala();
            $deleteUser->deleteUser($this->id);            
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma sala!</p>";
        }

        $urlRedirect = URLADM . "salas-nutricionista/index";
        header("Location: $urlRedirect");

    }
}
