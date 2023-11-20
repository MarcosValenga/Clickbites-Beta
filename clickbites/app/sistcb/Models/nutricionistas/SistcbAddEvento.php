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
class SistcbAddEvento
{
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $idSala;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    function getResult(): bool
    {
        return $this->result;
    }

    public function create(int $id, array $data = null)
    {
        $this->data = $data;
        $this->idSala = (int) $id;
    
        $this->add();

        
    }
    
    private function add(): void
    {	
        $this->data['fk_sala_id'] = $this->idSala;
        
        $data_start = str_replace('/', '-', $this->data['start']);
        $data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));
        $this->data['start'] = $data_start_conv;

        $data_end = str_replace('/', '-', $this->data['end']);
        $data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));
        $this->data['end'] = $data_end_conv;
        

        $createEvento = new \App\sistcb\Models\helper\SistcbCreate();
        $createEvento->exeCreate("cardapios", $this->data);

        if ($createEvento->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Evento adicionado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Evento não adicionada com sucesso!</p>";
            $this->result = false;
        }
        

    }

}
