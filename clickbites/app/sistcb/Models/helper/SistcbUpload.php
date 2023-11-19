<?php

namespace App\sistcb\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para upload
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class SistcbUpload  
{
    private string $directory;
    private string $tmpName;
    private string $name;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    public function upload(string $directory, string $tmpName, string $name): void
    {
        $this->directory = $directory;
        $this->tmpName = $tmpName;
        $this->name = $name;

        if($this->valDirectory()){
            $this->uploadFile();
        }else{
            $this->result = false;
        }
            
        
    }

    private function valDirectory() : bool
    {
        if((!file_exists($this->directory)) and (!is_dir($this->directory))){
            mkdir($this->directory, 0755, true);
            if((!file_exists($this->directory)) and (!is_dir($this->directory))){
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload não realizado com sucesso. Tente novamente</p>";
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    private function uploadFile(){
        if(move_uploaded_file($this->tmpName, $this->directory .  $this->name)){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload da Image não realizado com sucesso!</p>";
            $this->result = false;
        }
    }
}
