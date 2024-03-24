<?php

namespace Core;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Carregar as páginas da view
 * 
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ConfigView
{

    /**
     * Receber o endereço da VIEW e os dados
     * @param string $nameView Enderço da VIEW que deve ser carregada
     * @param array|string|null $data Dados que a VIEW deve receber
     */
    public function __construct(private string $nameView, private array|string|null $data)
    {
    }

    /**
     * Carregar a VIEW
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function loadViewAluno(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/sistcb/Views/include/headAluno.php';
            include 'app/sistcb/Views/include/navbarAluno.php';
            include 'app/sistcb/Views/include/menuAluno.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/sistcb/Views/include/footerAluno.php';
        } else {
            die("Erro - 0021: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }

    /**
     * Carregar a VIEW
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function loadViewNutricionista(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/sistcb/Views/include/headNutricionista.php';
            include 'app/sistcb/Views/include/navbarNutricionista.php';
            include 'app/sistcb/Views/include/menuNutricionista.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/sistcb/Views/include/footerNutricionista.php';
        } else {
            die("Erro - 003: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }

    /**
     * Carregar a VIEW login
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function loadViewLogin(): void
    {

        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/sistcb/Views/include/headlogin.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/sistcb/Views/include/footerlogin.php';
        } else {
            die("Erro - 004: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }
}
