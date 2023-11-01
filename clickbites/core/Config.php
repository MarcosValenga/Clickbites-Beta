<?php

namespace Core;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

abstract class Config
{
    protected function configAdm()
    {
        define('URL', 'http://localhost/clickbites/');
        define('URLADM', 'http://localhost/clickbites/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '1234');
        define('DBNAME', 'cardapio_ofc');
        define('PORT', '3306');

        define('EMAILADM', 'marcosvalenga360@gmail.com');
    } 
}