<?php
    session_start();
    header('Content-Type: text/html');
    if (empty($_REQUEST['request']))
        $request = null;
    else
        $request = $_REQUEST['request'];

    $section = $request;

    if (empty($_SESSION['usuario_activo']))
    {
      header("Location: login.php");
      die();
    } 
    else
    {
      include 'inc/templates/header.php';
      include 'inc/templates/sidebar.php';
      include 'inc/templates/inicio.php';
      if(empty($nivel_usuario)){
        switch($request){
          case 'datos':
            include 'inc/templates/empleados/vista-empleado.php';
            break;
          default:
            include 'inc/templates/empleados/vista-empleado.php';
            break;
        }
      }else{
        switch ($request)
          {
              case 'empleado': case'bajas':
                include 'inc/templates/empleados/vista.php';
                break;
              case 'alta-empleado':
                include 'inc/templates/empleados/alta-empleado.php';
                break;
              case 'altas':
                include 'inc/templates/altas/vista.php';
              break;
              case 'semanales':
                include 'inc/templates/altas/semanales.php';
                break;
              case 'datos':
                include 'inc/templates/empleados/vista-empleado.php';
                break;
              case 'direcciones':
                include 'inc/templates/transporte/vista.php';
                break;
              case 'fecha1': case 'fecha2':
                include 'inc/templates/dh/vista.php';
                break;
              case 'puestos':
                include 'inc/templates/modulos/puestos_vista.php';
                break;
              default:
                include 'inc/templates/main-content.php';
                break;
          }
      }
      include 'inc/templates/footer.php';
    }
?>