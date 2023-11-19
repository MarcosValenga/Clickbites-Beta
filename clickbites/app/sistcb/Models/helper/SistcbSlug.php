<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para converter o SLUG
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbSlug
{
    /** @var string $text Recebe o texto que deve ser convertido */
    private string $text;

    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;


    public function slug(string $text): string|null
    {

        $this->text = $text;
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr------------------------------------------------------------------------------------------------';
        $this->text = strtr(utf8_decode($this->text) ,  utf8_decode($this->format['a']), $this->format['b']); 
        $this->text = str_replace(" ", "-", $this->text);
        $this->text = str_replace(array('-----', '----', '---', '--'), '-', $this->text);
        $this->text = strtolower($this->text);

        return $this->text;
    }
}
