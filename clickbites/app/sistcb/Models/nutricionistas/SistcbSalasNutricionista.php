<?php

namespace App\sistcb\Models\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar os usuários do banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbSalasNutricionista
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número da página*/
    private int $page;

    /** @var string|int|null $limitResult Recebe a quantidade de registros que deve retornar do banco de dados*/
    private int $limitResult = 6;

    /** @var string|null $page Recebe a paginaçao*/
    private string|null $resultPg;


    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    public function listSalas(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\sistcb\Models\helper\SistcbPagination(URLADM . 'salas-nutricionista/index');
        $pagination->condition($this->page, $this->limitResult);

        // Consulta para contar o número de salas pertencentes ao nutricionista logado

        $pagination->pagination("SELECT COUNT(*) AS num_result FROM salas WHERE fk_nutricionista_id = :fk_nutricionista_id", "fk_nutricionista_id=" . $_SESSION['user_id']);
        $this->resultPg = $pagination->getResult();

        // Consulta para listar as salas do nutricionista logado
        $listSalas = new \App\sistcb\Models\helper\SistcbRead();
        $listSalas->fullRead("SELECT id, nome_sala, link_acesso, qrcode_acesso FROM salas WHERE fk_nutricionista_id = :fk_nutricionista_id
                                ORDER BY id DESC
                                LIMIT :limit OFFSET :offset", "fk_nutricionista_id=" . $_SESSION['user_id'] . "&limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultBd = $listSalas->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-info'>Você ainda não tem nenhuma sala. Click em Adicionar para criar uma!!</p>";
            $this->result = false;
        }
    }
}
