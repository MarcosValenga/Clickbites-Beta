<?php

namespace App\sistcb\Controllers\alunos;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class DesvincularSala
{
    
    /**
     * Método apagar usuário
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar usuários
     *
     * @param integer|string|null|null $id
     * @return void
     */
    public function index(): void
    {


        $deleteUser = new \App\sistcb\Models\alunos\SistcbDesvincularSala();
        $deleteUser->desvincularSala();            


        $urlRedirect = URLADM . "view-profile-aluno/index";
        header("Location: $urlRedirect");

    }
}
