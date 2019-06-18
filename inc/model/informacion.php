<?php
    if (isset($_GET['tipo'])) 
    {
        session_start();
        $fNacimiento = $_GET['fNacimiento'];
        $_SESSION['usuario_nivel'] = $fNacimiento;
    }
?>