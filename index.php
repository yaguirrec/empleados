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
          case 'perfil':
            include 'inc/templates/empleados/empleado.php';
            break;
          default:
            include 'inc/templates/empleados/empleado.php';
            break;
        }
      }else{
        switch ($request)
          {
              case 'empleado': case'bajas':
                include 'inc/templates/empleados/vista.php';
                break;
              case'bajaPuesto':
                include 'inc/templates/bajas/baja-puesto.php';
              break;
              case 'alta-empleado':
                include 'inc/templates/empleados/alta-empleado.php';
                break;
              case 'becarios':
                include 'inc/templates/empleados/vista.php';
                break;
              case 'modificar-empleado':
                include 'inc/templates/empleados/modificar.php';
                break;
              case 'empleadoBaja':
                  include 'inc/templates/empleados/baja-empleado.php';
                  break;
              case 'reingreso-empleado':
                  include 'inc/templates/empleados/reingreso.php';
                  break;
              case 'altas':
                include 'inc/templates/altas/vista.php';
              break;
              case 'administrarBajas':
                include 'inc/templates/bajas/vista.php';
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
              case 'admin-roles':
                include 'inc/templates/administracion/roles.php';
                break;
                case 'admin-cp':
                  include 'inc/templates/administracion/cp.php';
                  break;
              case 'administrar':
                include 'inc/templates/administracion/main.php';
                break;
              default:
                include 'inc/templates/main-content.php';
                break;
          }
      }
      include 'inc/templates/footer.php';
    }
?>