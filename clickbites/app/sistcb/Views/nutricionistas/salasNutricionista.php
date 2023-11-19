<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

?>


<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row-rl-tr">
        <div class="top-list">
            <span class="title-content">Lista de Salas</span>
            <div class="top-list-right">
                <?php
                echo "<a id='link-rl-tr' href='" . URLADM . "add-sala/index' class='btn-success'>Adicionar Nova Sala</a>";
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
        <div class="wrapper">
            <div class="row-rl-tr">

                <?php foreach ($this->data['listSalas'] as $sala) {
                    extract($sala); ?>
                    <a <?php echo "href='" . URLADM . "calendario-interativo/index?id=$id'"; ?>" class="sala-link">
                            <div class="sala-box" data-sala-id="<?php echo $id; ?>" data-link-acesso="<?php echo $link_acesso; ?>">
                                <h3><?php echo $nome_sala; ?></h3>
                                <img src="<?php echo URLADM . "$qrcode_acesso"; ?>" alt="qrcode">
                                <div class="icon-corner">
                                    <a class="fa-solid fa-copy meuLink" href="#" data-link-acesso="<?php echo $link_acesso; ?>"></a>
                                </div>

                                <div class="icon-edit">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                    <div class="dropdown-cl-tr">
                                        <ul>
                                            <li><?php echo "<a href='" . URLADM . "delete-sala/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir esta sala?\")'>Apagar</a>"; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </a>
                <?php } ?>

            </div>
        </div>
        <?php echo $this->data['pagination']; ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->