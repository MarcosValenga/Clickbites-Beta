<?php

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Perfil</span>
            <div class="top-list-right">
                <?php
                if (!empty($this->data['viewProfile'])) {
                    echo "<a id='link-rl-tr' href='".URLADM."edit-profile/index/".$_SESSION['user_id']."' class='btn-warning'>Editar</a> ";
                }
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
        </div>
        <div class="content-adm">
            <?php
                if (!empty($this->data['viewProfile'])) {
                    $usuario = $this->data['viewProfile'][0];
                    extract($usuario);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Foto:</span>
                    <span class="view-adm-info"><?php if (!empty($imagem) and (file_exists("app/sistcb/assets/image/users/".$_SESSION['user_tipo']."/".$_SESSION['user_id']."/$imagem"))) {
                                                    echo "<img src='" . URLADM . "app/sistcb/assets/image/users/".$_SESSION['user_tipo']."/".$_SESSION['user_id']."/$imagem' width='100' height='100'>";
                                                } else {
                                                    echo "<img src='" . URLADM . "app/sistcb/assets/image/users/not_found_img.png' width='100' height='100'>";
                                                } ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $nome; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">E-mail: </span>
                    <span class="view-adm-info"><?php echo $email; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Usuário: </span>
                    <span class="view-adm-info"><?php echo $user; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Certificado Nutricionista:</span>
                    <?php
                        if (isset($certificado_nut) && !is_null($certificado_nut)) {
                            echo "<span class='view-adm-info'>$certificado_nut</span>";
                        }else{
                            echo "<span class='view-adm-info'>Nenhum Certificado Indexado</span>";
                        }
                    ?>
                    

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->