<?php
$action  = $_POST['action'];

switch ($action){
        
    case 'envioAltas':
        // die(json_encode($_POST));
        $fechaAlta = $_POST['fechaAlta'];
        $correo_destinatario = 'cesar.fonseca20@outlook.com';
        $nombre_destinatario = 'César Valenciano';
        $asunto = 'Envio de altas '.$fechaAlta;
        $datos = $_POST['datos'];
        $headers = 'Content-Type: text/html; charset=UTF-8';
        foreach($datos as $dato){
            $datos .=$dato . "\n";
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
								<p>Altas de empleado(s):</p> <p>'. $datos .'</p>
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