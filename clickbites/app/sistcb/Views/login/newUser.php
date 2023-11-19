<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<div class="container-login">
    <div class="wrapper-login">

        <div class="title">
            <span>Cadastro</span>
        </div>

        <div class="msg-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            } else {
                echo "<span id='msg'></span>";
            }
            ?>
        </div>


        <form method="POST" action="" id="form-new-user" class="form-login">
            <?php
            $name = "";
            if (isset($valorForm['nome'])) {
                $name = $valorForm['nome'];
            }
            ?>
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome completo" value="<?php echo $name; ?>" required>
            </div>

            <?php
            $email = "";
            if (isset($valorForm['email'])) {
                $email = $valorForm['email'];
            }
            ?>
            <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>" required>
            </div>

            <?php
            $password = "";
            if (isset($valorForm['password'])) {
                $password = $valorForm['password'];
            }
            ?>
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
            </div>

            <span id="msgViewStrength"></span>

            <?php
            $tipo = "";
            if (isset($valorForm['tipo'])) {
                $tipo = $valorForm['tipo'];
            }
            ?>
            <label class="title-input">Selecione o tipo de usuário:</label>
            <div class="radio-buttons">
                <input type="radio" name="tipo_usr" id="aluno" value="aluno" <?php echo ($tipo === 'aluno') ? 'checked' : ''; ?> checked>
                <label for="aluno">Aluno</label>

                <input type="radio" name="tipo_usr" id="nutricionista" value="nutricionista" <?php echo ($tipo === 'nutricionista') ? 'checked' : ''; ?>>
                <label for="nutricionista">Nutricionista</label>
            </div>

            <div class="row button">
                <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
            </div>

            <div class="signup-link">
                <p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>
            </div>
        </form>
    </div>
</div>