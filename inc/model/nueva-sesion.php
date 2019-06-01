<?php
    if (isset($_GET['id']) && isset($_GET['name'])) 
    {
        session_start();
        $_SESSION['usuario_activo'] = $_GET['id'];
        $_SESSION['usuario_nombre'] = $_GET['name'];
        $_SESSION['usuario_nivel'] = $_GET['nivel'];
        $_SESSION['login'] = true;
    }
?>