<?php


if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}


if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>



<div class="my-container">
<!-- Inicio container Cadastro -->
    <div class="content first-content">
        <div class="first-column">
            <h2 class="title">Bem-Vindo!</h2>
            <p class="description description-primary">Test1</p>
            <p class="description description-primary">Test2</p>
            <button class="botao botao-primary">Login</button>
        </div><!-- first-column -->
        <div class="second-column">
            <h2 class="title">Crie uma Conta</h2>
            <div class="custom-social-midia">
                <ul class="list-social-midia">
                    <a class="link-social-midia" href="#">
                        <li class="item-social-midia" title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </li>
                    </a>
                    <a class="link-social-midia" href="#">
                        <li class="item-social-midia" title="Google">
                            <i class="fa-brands fa-google"></i>
                        </li>
                    </a>
                </ul>
            </div><!-- custom-social-midia -->
            <p class="description-second">ou use seu email para cadastro</p>
            <!-- Formulario Cadastro -->
            <form method="POST" action="" id="form-new-user" class="custom-form">

                <?php
                $name = "";
                if (isset($valorForm['nome'])) {
                    $name = $valorForm['nome'];
                }
                ?>
                <label class="input-label" for="">
                    <i class="fa-solid fa-user icon-modify"></i><input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $name; ?>" required>
                </label>
                
                <?php
                $email = "";
                if (isset($valorForm['email'])) {
                    $email = $valorForm['email'];
                }
                ?>
                <label class="input-label"for="">
                    <i class="fa-solid fa-envelope icon-modify"></i><input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required>
                </label>

                <?php
                $password = "";
                if (isset($valorForm['password'])) {
                    $password = $valorForm['password'];
                }
                ?>
                <label class="input-label"for="">
                    <i class="fa-solid fa-lock icon-modify"></i><input type="password" name="password" id="password" placeholder="Senha"  onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
                    <span id="msgViewStrength"></span>
                </label>
                
                <?php
                $tipo = "";
                if (isset($valorForm['tipo'])) {
                    $tipo = $valorForm['tipo'];
                }
                ?>
                <label>Selecione o tipo de usuário:</label>
                <div>
                    <input type="radio" name="tipo_usr" id="aluno" value="aluno" <?php echo ($tipo === 'aluno') ? 'checked' : ''; ?> checked>
                    <label for="aluno">Aluno</label>

                    <input type="radio" name="tipo_usr" id="nutricionista" value="nutricionista" <?php echo ($tipo === 'nutricionista') ? 'checked' : ''; ?>>
                    <label for="nutricionista">Nutricionista</label>
                </div>

                <button class="botao botao-second" type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
            </form>
        </div><!-- second-column -->
    </div><!-- content-first -->
<!-- Fim container Cadastro -->

<!-- Inicio container Login -->
    <div class="content second-content">
        <div class="first-column">
            <h2 class="title">Bem-vindo!</h2>
            <p class="description description-primary">Test1</p>
            <p class="description description-primary">Test2</p>
            <button class="botao botao-primary">Logar</button>
        </div>
        <div class="second-column">
            <h2 class="title">Login</h2>
            <div class="custom-social-midia">
                <ul class="list-social-midia">
                    <a class="link-social-midia" href="#">
                        <li class="item-social-midia" title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </li>
                    </a>
                    <a class="link-social-midia" href="#">
                        <li class="item-social-midia" title="Google">
                            <i class="fa-brands fa-google"></i>
                        </li>
                    </a>
                    
                </ul>
            </div>
        
            <p class="description discription-second">ou use seu email para login</p>
            <!-- Formulario Login -->
            <form method="POST" action="" id="form-login" class="custom-form">
                <?php
                $user = "";
                if (isset($valorForm['user'])) {
                    $user = $valorForm['user'];
                }
                ?>
                <label class="input-label" for="">
                    <i class="fa-solid fa-user icon-modify"></i><input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php echo $user; ?>" required>
                </label>

                <?php
                $password = "";
                if (isset($valorForm['password'])) {
                    $password = $valorForm['password'];
                }
                ?>
                <label class="input-label" for="">
                    <i class="fa-solid fa-lock icon-modify"></i><input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php echo $password;?>" required>
                </label>

                <a class="password" href="#">esqueceu sua senha?</a>
                
                <button class="botao botao-second" type="submit" name="SendLogin" value="Acessar">Acessar</button>
            </form>
        </div> 
    </div><!-- Content-Second -->    
</div><!-- My-conteiner -->

<!-- Fim container Login -->



<!-- Login Antigo 
<div class="container-login">
    <div class="wrapper-login">
        <div class="title">
            <span>Login - Click Bites</span>
        </div>

        <div class="msg-alert">
        <?php
        //if (isset($_SESSION['msg'])) {
        //    echo $_SESSION['msg'];
        //    unset($_SESSION['msg']);
        //} else {
        //    echo "<span id='msg'></span>";
        //}
        ?>
        </div>

        <form method="POST" action="" id="form-login" class="form-login">
            <?php
            //$user = "";
            //if (isset($valorForm['user'])) {
            //    $user = $valorForm['user'];
            //}
            ?>
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php //echo $user; ?>" required>
            </div>

            <?php
            //$password = "";
            //if (isset($valorForm['password'])) {
            //    $password = $valorForm['password'];
            //}
            ?>
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php //echo $password;?>" required>
            </div>

            <div class="row button">
                <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
            </div>

            <div class="signup-link">
                <a href="<?php //echo URLADM; ?>new-user/index">Cadastrar</a> - <a href="<?php //echo URLADM; ?>recover-password/index">Esqueceu a senha?</a>
            </div>
        </form>
    </div>
</div>
-->