<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PDOException;
use PDO;

/**
 * Conecta ao banco de dados
 * @author Marcos <marcosvalenga360@gmail.com>
 */
abstract class SistcbConn{
    /**
     * Summary of host
     * @var string $host Recebe os dados host da Config
     */
    private string $host = HOST;
    /**
     * Summary of user
     * @var string $user Recebe os dados user da Config
     */
    private string $user = USER;
    /**
     * Summary of pass
     * @var string $pass Recebe os dados password da Config
     */
    private string $pass = PASS;
    /**
     * Summary of dbname
     * @var string $dbname identifica qual DB será usando da Config
     */
    private string $dbname = DBNAME;
    /**
     * Summary of port
     * @var int|string $port Recebe os dados da porta da Config
     */
    private int|string $port = PORT;
    /**
     * Summary of connect
     * @var object $connect Recebe a conexão com o banco de dados
     */
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não reallizando o conexao corretamente, para o processamento da página e 
     * apresenta a mensagem de ero, com o e-mail de contato do administrador.
     * @return object retona a conexão com o banco de dados
     */
    protected function connectDb(): object
    {
        try{
            //Conexao com a porta
            $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=" .$this->dbname, $this->user, $this->pass);
            return $this->connect;
        }catch(PDOException $err){
            die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ". EMAILADM);
        }
    }
    
}