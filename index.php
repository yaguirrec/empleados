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
        // header("Location: index.php?request=datos");
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
              case 'datos':
                  include 'inc/templates/empleados/vista-empleado.php';
                  break;
              case 'direcciones':
                  include 'inc/templates/transporte/vista.php';
                  break;
              default:
                  include 'inc/templates/main-content.php';
                  break;
          }
      }
      include 'inc/templates/footer.php';
    }
?>