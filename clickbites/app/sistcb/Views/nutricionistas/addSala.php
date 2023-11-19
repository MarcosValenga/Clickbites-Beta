<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Adicionar Sala</span>
            <div class="top-list-right">
                <?php
                echo "<a id='link-rl-tr' href='" . URLADM . "salas-nutricionista/index' class='btn-info'>Salas</a> ";
                ?>
            </div>
        </div>
        <div class="content-adm">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>
        <div class="content-adm">
            <form method="POST" action="" id="form-add-sala" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $nome_sala = "";
                        if (isset($valorForm['nome_sala'])) {
                            $nome_sala = $valorForm['nome_sala'];
                        }
                        ?>
                        <label class="title-input">Nome da Sala: </label>
                        <input type="text" name="nome_sala" id="nome_sala" class="input-adm" placeholder="Digite o nome da sala" value="<?php echo $nome_sala; ?>">
                    </div>
                </div>

                <!-- Adicione aqui os demais campos do formulário -->

                <button type="submit" name="SendAddSala" value="Cadastrar" class="btn-success">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->