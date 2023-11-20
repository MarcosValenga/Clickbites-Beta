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
        
        <a  href="<?php echo URLADM; ?>central-aluno/index" class="sidebar-nav <?php if($sidebar_active == "dashboard") { echo "active";}?>"><i class="icon fa-solid fa-house"></i><span>Principal</span></a>

        <?php if(!empty($_SESSION['user_vinculo'])) { ?>
            <a id='link-rl-tr' href="<?php echo URLADM; ?>calendario-view/index?id=<?php echo $_SESSION['user_vinculo']; ?>" class="sidebar-nav <?php if($sidebar_active == "calendario-view") { echo "active"; } ?>"><i class="icon fa-solid fa-users"></i><span>Minha Sala</span></a>
        <?php } ?>

    </div>
    <!-- Fim da Sidebar -->

