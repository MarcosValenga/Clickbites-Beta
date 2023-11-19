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
        
        <a id='link-rl-tr' href="<?php echo URLADM; ?>central-nutricionista/index" class="sidebar-nav <?php if($sidebar_active == "central-nutricionista") { echo "active";}?>"><i class="icon fa-solid fa-house"></i><span>Página Principal</span></a>

        <a id='link-rl-tr' href="<?php echo URLADM; ?>salas-nutricionista/index" class="sidebar-nav <?php if($sidebar_active == "list-users") { echo "active";}?>"><i class="icon fa-solid fa-users"></i><span>Minhas Salas</span></a>

    </div>
    <!-- Fim da Sidebar -->

