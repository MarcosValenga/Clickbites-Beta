<header>
    <!-- Inicio Navbar -->
    <nav class="navbar">
        <div class="navbar-content">
            <!--<div class="bars">
                <i class="fa-solid fa-bars fa-xl"></i>
            </div>-->
            <img src="<?php echo URLADM; ?>app/sistcb/assets/logos/logo2.png" alt="Celke" class="logo">
            <h1>Click Bites</h1>
        </div>
        
        <div class="navbar-content">
            <div class="avatar">
                <?php 
                if(!empty($_SESSION['user_imagem']) and (file_exists("app/sistcb/assets/image/users/".$_SESSION['user_tipo']. "/".$_SESSION['user_id']."/".$_SESSION['user_imagem']))){
                    echo "<img src='".URLADM."app/sistcb/assets/image/users/".$_SESSION['user_tipo']. "/".$_SESSION['user_id']."/".$_SESSION['user_imagem']."' width='40' height='40'>";
                } else {
                    echo "<img src='".URLADM."app/sistcb/assets/image/users/not_found_img.png' width='40' height='40'>";
                }
                ?>
                <div class="dropdown-menu-real setting">
                    <a  href="<?php echo URLADM; ?>view-profile-aluno/index" class="item">
                        <span class="fa-solid fa-user"></span> Perfil
                    </a>
                    
                    <a  href="<?php echo URLADM; ?>edit-profile-aluno/index/<?php echo $_SESSION['user_id']; ?>?tipo=<?php echo $_SESSION['user_tipo']; ?>" class="item">
                        <span class="fa-solid fa-gear"></span> Configuração
                    </a>

                    <a  href="<?php echo URLADM; ?>logout/index" class="item">
                        <span class="fa-solid fa-arrow-right-from-bracket"></span> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Fim Navbar -->
</header>