<head>
    <nav class="navbar sticky-top navbar-expand-lg bg-primary justify-content-between">

        <a class="navbar-brand">
        <img src="img/whiteLogo.png" width="150" alt="Logo MEXQ" class="responsive-img">
        </a>
        <!-- <?php if (!isset($_SESSION['login']) || empty($_SESSION['login'])){  ?> -->
        <a class="nav-item nav-link disabled text-white">Resguardo de Equipos MEXQ</a>
        <!-- <?php } else {?> -->
        <!-- <?php 
                $usuario_nombre = $_SESSION['usuario_nombre'];
                $usuario_id = $_SESSION['usuario_activo'];
                $usuario_departamento = $_SESSION['usuario_departamento'];
                $ti_acceso = '117';//Variable departamento de sistemas
        ?> -->
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <form class="form-inline">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-item nav-link menuLink" href="index.php?request=main-page">Menu <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link computersLink" href="index.php?request=computers">Equipos de computo</a>
            <a class="nav-item nav-link smartphonesLink" href="index.php?request=smartphone">Smartphones</a>
            <a class="nav-item nav-link printersLink" href="index.php?request=printers">Impresoras</a>
            <a class="nav-item nav-link disabled text-white" href="#">Bienvenido (a) Usuario</a>
            <a class="nav-item nav-link btn btn-danger" type="button" id="btnSalir"> Cerrar Sesión <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
        </form>
        <!-- <input id='ipDepto' type="hidden" value="<?php echo $usuario_departamento; ?>" disabled>
        <input id='ipTI' type="hidden" value="<?php echo $ti_acceso; ?>" disabled> -->

        <!-- <?php } ?> -->
    </nav>
    <br>
</head>