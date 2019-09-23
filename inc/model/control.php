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
        case 'guardarFoto':
            // die(json_encode($_POST));
            $empNomina = $_POST['empNomina'];
            
            if(isset($_FILES["empFoto"]["name"])){
                $respuesta = array(
                    'estado' => 'OK'
                );
                $directorio = '../../assets/files/'.$empNomina;
                $targetDir = $directorio."/";       
                if(!file_exists($directorio))
                {
                    mkdir($directorio, 0777,true);
                }
                $temp = explode(".", $_FILES["empFoto"]["name"]);
                $newfilename = $empNomina . '.jpg';
                
                move_uploaded_file($_FILES["empFoto"]["tmp_name"], $targetDir . $newfilename);
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
        break;
        case 'revisarImagen':
            // die(json_encode($_POST));
            $ruta = '../../assets/files/';
            $empNomina = $_POST['nomina'];
            $respuesta = array(
                'estado' => 1
            );

            if (!file_exists($ruta.$empNomina.'/'.$empNomina.'.jpg')) {   
                $respuesta = array(
                    'estado' => 0
                );                        
            }
                
            echo json_encode($respuesta);
        break;
        case 'envioAcuse':
            // die(json_encode($_POST));
            $nombreAdjuntoAcuse = $_POST['nombreAdjuntoAcuse'];
            
            if(isset($_FILES["adjuntoAcuse"]["name"])){
                $respuesta = array(
                    'estado' => 'OK'
                );
                $directorio = '../../assets/attached/Acuses';
                $targetDir = $directorio."/";       
                if(!file_exists($directorio))
                {
                    mkdir($directorio, 0777,true);
                }
                $temp = explode(".", $_FILES["adjuntoAcuse"]["name"]);
                $newfilename = $nombreAdjuntoAcuse . '.' . end($temp);
                
                move_uploaded_file($_FILES["adjuntoAcuse"]["tmp_name"], $targetDir . $newfilename);
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
        break;
        case 'envioProcesada':
            // die(json_encode($_POST));
            $nombreAdjuntoProcesada = $_POST['nombreAdjuntoProcesada'];
            
            if(isset($_FILES["adjuntoProcesada"]["name"])){
                $respuesta = array(
                    'estado' => 'OK'
                );
                $directorio = '../../assets/attached/Procesadas';
                $targetDir = $directorio."/";       
                if(!file_exists($directorio))
                {
                    mkdir($directorio, 0777,true);
                }
                $temp = explode(".", $_FILES["adjuntoProcesada"]["name"]);
                $newfilename = $nombreAdjuntoProcesada . '.' . end($temp);
                
                move_uploaded_file($_FILES["adjuntoProcesada"]["tmp_name"], $targetDir . $newfilename);
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
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