<?php 
session_start();
$action = $_POST['action'];

switch($action)
{
    case 'salir':
            // die(json_encode($_POST));
            // session_start();
            $_SESSION = array();  
            $respuesta = array (
                'estado' => 'OK',
                'tipo' => 'success',
                'mensaje' => 'Sesión finalizada',
                'informacion' => 'Su sesión fue cerrada exitosamente.'
            );
            echo json_encode($respuesta);
            session_destroy();
            session_commit();
            break;
        default:
            $respuesta = array(
                'estado' => 'ERROR',
                'data' => 'Sin Información',
                'log' => 'Error al solicitar información'
            );
            echo json_encode($respuesta);    
        break;
}

?>