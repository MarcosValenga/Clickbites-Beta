<?php

namespace App\sistcb\Models\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Modelo para manipulação de dados de eventos do calendário
 * @package App\sistcb\Models\nutricionistas
 */
class SistcbCalendarioInterativo
{
    private bool $result;
    private array|null $resultBd;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function obterEventos(int $idSala): void
    {
        var_dump( $idSala);
        $listEvent = new \App\sistcb\Models\helper\SistcbRead();
        $listEvent->fullRead("SELECT * FROM cardapios WHERE fk_sala_id = :id_sala", "id_sala={$idSala}");
        $this->resultBd = $listEvent->getResult();
        var_dump( $this->resultBd);
        if ($this->resultBd){
            var_dump("Passou aqui");
            $this->result = True;
        }else{
            $this->result = false;
        }

    }
}
