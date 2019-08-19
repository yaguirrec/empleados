<?php
$action  = $_POST['action'];

switch ($action){
        
    case 'envioAltas':
        // die(json_encode($_POST));
        $fechaAlta = $_POST['fechaAlta'];
        $cc = $_POST['cc'];
        $correo_destinatario = 'cesar.fonseca20@outlook.com';
        $nombre_destinatario = 'César Valenciano';
        $asunto = 'Envio de altas '.$fechaAlta;
        $datos = $_POST['datos'];
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // $headers .= 'Cc: '.$cc.'@mexq.com.mx' . "\r\n";
        foreach($datos as $dato){
            $data .= $dato . '</br>';
        }
        $contenido = 	'
						<html>
							<head>
								<meta charset="UTF-8">
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$asunto.'</title>
							</head>
							<body>
                                <p>Hola '. $nombre_destinatario .'</p>
                                <p>Altas de empleado(s):</p> 
                                <p>'. 
                                $data
                                .'</p>
								<p>En el siguiente link podra acceder sistema web de empleados</p>
								<a href="http://mexq.mx/empleados">Verificar altas</a>
							</body>
						</html>
                        ';
        mail ($correo_destinatario, $asunto, $contenido, $headers, '-f contacto@mexq.com.mx');
    break;
    default:
    break;
}

?>