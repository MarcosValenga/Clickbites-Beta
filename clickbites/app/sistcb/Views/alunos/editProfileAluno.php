<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form']['profile'])) {
    $valorFormProfile = $this->data['form']['profile'];
}
if (isset($this->data['form']['image'])) {
    $valorFormImage = $this->data['form']['image'];
}

?>

<?php
if (isset($this->data['form']['profile'][0])) {
    $valorFormProfile = $this->data['form']['profile'][0];
}
if (isset($this->data['form']['image'][0])) {
    $valorFormImage = $this->data['form']['image'][0];
}
?>
<!-- Inicio do conteudo do administrativo -->
<!-- Inicio do conteudo do Editar Imagem -->

<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Editar Imagem</span>
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
            <form method="POST" action="" id="form-edit-prof-img" enctype="multipart/form-data" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <label>Foto de Perfil: </label>
                        <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()"><br><br>

                        <?php
                        if (!empty($valorFormImage['imagem']) and (file_exists("app/sistcb/assets/image/users/".$_SESSION['user_tipo']."/" . $_SESSION['user_id'] . "/" . $valorFormImage['imagem']))) {
                            $old_image = URLADM . "app/sistcb/assets/image/users/".$_SESSION['user_tipo']."/" . $_SESSION['user_id'] . "/" . $valorFormImage['imagem'];
                        } else {
                            $old_image = URLADM . "app/sistcb/assets/image/users/not_found_img.png";
                        }
                        ?>
                        <span id="preview-img">
                            <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px">
                        </span>
                    </div>
                </div>

                <button type="submit" name="SendEditProfImage" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do Editar Imagem -->
<!-- Inicio do conteudo do Editar Perfil -->
<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Editar Perfil</span>
            <div class="top-list-right">
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
            <form method="POST" action="" id="form-edit-profile" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $name = "";
                        if (isset($valorFormProfile['nome'])) {
                            $name = $valorFormProfile['nome'];
                        }
                        ?>
                        <label class="title-input">Nome: </label>
                        <input type="text" name="nome" id="nome" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $name; ?>">
                    </div>

                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                        $email = "";
                        if (isset($valorFormProfile['email'])) {
                            $email = $valorFormProfile['email'];
                        }
                        ?>
                        <label class="title-input">E-mail: </label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>">
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $user = "";
                        if (isset($valorFormProfile['user'])) {
                            $user = $valorFormProfile['user'];
                        }
                        ?>
                        <label class="title-input">Usuário: </label>
                        <input type="text" name="user" id="user" class="input-adm" placeholder="Digite o usuário" value="<?php echo $user; ?>">
                        
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                    <label class="title-input">Sair da Sala: </label>
                        <button class="btn-danger" ><?php echo "<a style='color: #000' href='" . URLADM . "desvincular-sala/index' onclick='return confirm(\"Tem certeza que deseja desvincular-se da sala?\")'>Desvincular</a>"; ?></button>
                    </div>
                </div>
                <button type="submit" name="SendEditProfile" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do Editar Perfil -->
<!-- Inicio do conteudo do Editar Senha -->
<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Editar Senha do Usuário</span>
            <div class="top-list-right">
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
            <form method="POST" action="" id="form-edit-user-pass" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Senha:<span style='color: #f00;'>*</span></label>
                        <input type="password" name="password" id="password" class="input-adm" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="" required><br>
                        <span id="msgViewStrength"></span>
                    </div>
                </div>
                <button type="submit" name="SendEditProfPass" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do Editar Senha -->
<!-- Fim do conteudo do administrativo -->