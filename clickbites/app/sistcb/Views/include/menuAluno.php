<?php 
    if(!defined('CL1K3B1T35')){
        header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

$sidebar_active = "";
if(isset($this->data['sidebarActive'])){
    $sidebar_active = $this->data['sidebarActive'];

}
?>  

<!-- inicio conteudo -->
<div class="content">
    <!-- inicio da side bar -->
    <div class="sidebar">
        
        <a  href="<?php echo URLADM; ?>central-aluno/index" class="sidebar-nav <?php if($sidebar_active == "dashboard") { echo "active";}?>"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

        <a  href="<?php echo URLADM; ?>list-users/index" class="sidebar-nav <?php if($sidebar_active == "list-users") { echo "active";}?>"><i class="icon fa-solid fa-users"></i><span>Usuários</span></a>

    </div>
    <!-- Fim da Sidebar -->

