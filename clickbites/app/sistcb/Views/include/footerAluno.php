<?php 
    if(!defined('CL1K3B1T35')){
        header("Location: /");
        die("Erro: Página não encontrada<br>");
    }
?>    
    
<head>
    <link rel="stylesheet" href="custom_adm.css">
</head>

</div>

<footer>
    <div class='container'>
    <div class='row-rl-tr'>
        <div class='col-md-12'>
            <ul>
                <p><?php echo date('Y'); ?> &copy; Click Bites</p>
            </ul>
        </div>
    </div>
    </div>
</footer>

    <!-- FULL CALENDER JS -->
    <script src='<?php echo URLADM;?>app/sistcb/assets/js/core/main.min.js'></script>
    <script src='<?php echo URLADM;?>app/sistcb/assets/js/interaction/main.min.js'></script>
    <script src='<?php echo URLADM;?>app/sistcb/assets/js/daygrid/main.min.js'></script>
    <script src='<?php echo URLADM;?>app/sistcb/assets/js/core/locales/pt-br.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Fim -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src='<?php echo URLADM;?>app/sistcb/assets/js/personalizado.js'></script>
    <script src="<?php echo URLADM; ?>app/sistcb/assets/js/custom_aluno.js"></script>    
    </body>
</html>