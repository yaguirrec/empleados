<?php 
include 'bucket-service.php';
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
            if(isset($_FILES["empFoto"]["name"])){
                $employeePayroll = $_POST['empNomina'];
                $employeePhoto = $_FILES["empFoto"]["tmp_name"];
                $bucketService = new BucketService();
                if ($bucketService->saveImage($employeePhoto, $employeePayroll)) {
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                } else {
                    $respuesta = array(
                        'estado' => 'NOK'
                    );
                }
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
        break;
        case 'revisarImagen':
            $ruta = '../../assets/files/';
            $empNomina = $_POST['nomina'];
            $respuesta = array(
                'estado' => 1
            );
            $bucketService = new BucketService();
            if ($bucketService->checkIfFileExists(AWS_FACE_RECOGNITION_BUCKET_NAME, "$empNomina.jpg")) {
                $respuesta = array(
                    'estado' => 1
                );
            } else {
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
                $temp = explode(".", $_FILES["adjuntoAcuse"]["name"]);
                $newFileName = $nombreAdjuntoAcuse . '.' . end($temp);
                
                $employeeFile = $_FILES["adjuntoAcuse"]["tmp_name"];
                $bucketService = new BucketService();
                if ($bucketService->saveEmployeeFile($employeeFile, "Acuses/$newFileName")) {
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                } else {
                    $respuesta = array(
                        'estado' => 'NOK'
                    );
                }
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
                $temp = explode(".", $_FILES["adjuntoProcesada"]["name"]);
                $newFileName = $nombreAdjuntoProcesada . '.' . end($temp);
                
                $employeeFile = $_FILES["adjuntoProcesada"]["tmp_name"];
                $bucketService = new BucketService();
                if ($bucketService->saveEmployeeFile($employeeFile, "Procesadas/$newFileName")) {
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                } else {
                    $respuesta = array(
                        'estado' => 'NOK'
                    );
                }
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
        break;
        case 'envioAcuseBaja':
            // die(json_encode($_POST));
            //
            $nombreAdjuntoAcuse = $_POST['nombreAdjuntoAcuse'];
            
            if(isset($_FILES["adjuntoAcuse"]["name"])){
                $temp = explode(".", $_FILES["adjuntoAcuse"]["name"]);
                $newFileName = $nombreAdjuntoAcuse . '.' . end($temp); 
                
                $employeeFile = $_FILES["adjuntoAcuse"]["tmp_name"];
                $bucketService = new BucketService();
                if ($bucketService->saveEmployeeFile($employeeFile, "Bajas/Acuses/$newFileName")) {
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                } else {
                    $respuesta = array(
                        'estado' => 'NOK'
                    );
                }
            } else {
                $respuesta = array(
                    'estado' => 'NOK'
                );
            }
        break;
        case 'envioProcesadaBaja':
            // die(json_encode($_POST));
            $nombreAdjuntoProcesada = $_POST['nombreAdjuntoProcesada'];
            
            if(isset($_FILES["adjuntoProcesada"]["name"])){
                $temp = explode(".", $_FILES["adjuntoProcesada"]["name"]);
                $newFileName = $nombreAdjuntoProcesada . '.' . end($temp);
                
                $employeeFile = $_FILES["adjuntoProcesada"]["tmp_name"];
                $bucketService = new BucketService();
                if ($bucketService->saveEmployeeFile($employeeFile, "Bajas/Procesadas/$newFileName")) {
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                } else {
                    $respuesta = array(
                        'estado' => 'NOK'
                    );
                }
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