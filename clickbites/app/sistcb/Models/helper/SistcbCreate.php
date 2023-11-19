<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PDO;
use PDOException;

/**
 * Classe gernérica para cadastrar registro no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbCreate extends SistcbConn
{
    /** @var string $table Recebe o nome da tabela */
    private string $table;

    /** @var array $data Recebe os dados que devem ser inseridos no BD */
    private array $data;

    /** @var string|null $result Retorna o status do cadastro */
    private string|null $result = null;

    /** @var object $insert Recebe a QUERY preparada */
    private object $insert;

    /** @var string $query Recebe a QUERY */
    private string $query;

    /** @var object $conn Recebe a conexão com o BD */
    private object $conn;

    /**
     * Retornar o status do cadastro, retorna o último id quando cadatrar com sucesso e null quando houver erro
     * @return string|null Retorna o último id inserido
     * 
    */
    function getResult(): string
    {
        return $this->result;
    }

    

    /**
     * Cadatrar no banco de dados
     * 
     * @param string $table Recebe o nome da tabela
     * @param array $data Recebe os dados do formulário
     * @return void
     */
    public function exeCreate(string $table, array $data):void
    {
        $this->table = $table;
        $this->data = $data;
        $this->exeReplaceValues();        
    }

    /**
     * Cria a QUERY e os links da QUERY
     * 
     * @return void
     */
    private function exeReplaceValues(): void
    {
        $coluns = implode(', ', array_keys($this->data));
        //var_dump($coluns);
        $values = ':' . implode(', :', array_keys($this->data));
        //var_dump($values);
        $this->query = "INSERT INTO {$this->table} ($coluns) VALUES ($values)";
        //var_dump($this->query);
        $this->exeInstruction();

    }

    /**
     * Executa a QUERY. 
     * Quando executa a query com sucesso retorna o último id inserido, senão retorna null.
     * 
     * @return void
     */
    private function exeInstruction(): void
    {
        $this->connection();
        try{
            $this->insert->execute($this->data);
            $this->result = $this->conn->lastInsertId();
            //var_dump($this->result);
        }catch(PDOException $err){
            //var_dump($this->result);
            $this->result = null;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectDb();
        //var_dump($this->conn);
        $this->insert = $this->conn->prepare($this->query);
    }
}
