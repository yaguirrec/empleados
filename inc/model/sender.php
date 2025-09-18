<?php
$action  = $_POST['action'];
$url = siteurl;

switch ($action){
        
    case 'envioAltas':
        // die(json_encode($_POST));
        $fecha = $_POST['fecha'];
        $cc = $_POST['cc'];
        $correo_destinatario = 'irivera@mexq.com.mx';
        $asunto = 'Envio de altas '. $fecha;
        $datos = $_POST['datos'];
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // $headers .= 'To: cvalenciano01@mexq.com.mx, sgomez@mexq.com.mx'. "\r\n";
        $headers .= 'To: agomez@mexq.com.mx, stafflaborales@mexq.com.mx, pvaldez@mexq.com.mx' . "\r\n";
        $headers .= 'Cc: '.$cc.'@mexq.com.mx' . "\r\n";
        foreach($datos as $dato){
            $data .= '<p>' . $dato . '</p>';
        }
        $contenido = 	'
						<html>
							<head>
								<meta charset="UTF-8">
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$asunto.'</title>
							</head>
							<body>
                                <p>Envio de altas de la fecha '. $fecha .'</p>
                                <p>Altas de empleado(s):</p> 
                                <p>'. 
                                $data
                                .'</p>
								<p>En el siguiente link podra acceder sistema web de empleados</p>
								<center><h2><a href="'.$url.'">Verificar altas</a></h2></center>
							</body>
						</html>
                        ';
        mail ($correo_destinatario, $asunto, $contenido, $headers, '-f '.$cc.'@mexq.com.mx');
    break;
    case 'envioBajas':
        // die(json_encode($_POST));
        $fecha = $_POST['fecha'];
        $cc = $_POST['cc'];
        $correo_destinatario = 'irivera@mexq.com.mx';
        $asunto = 'Envio de Bajas '. $fecha;
        $datos = $_POST['datos'];
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'To: agomez@mexq.com.mx, stafflaborales@mexq.com.mx, pvaldez@mexq.com.mx' . "\r\n";
        $headers .= 'Cc: '.$cc.'@mexq.com.mx' . "\r\n";
        foreach($datos as $dato){
            $data .= '<p>' . $dato . '</p>';
        }
        $contenido = 	'
						<html>
							<head>
								<meta charset="UTF-8">
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$asunto.'</title>
							</head>
							<body>
                                <p>Envio de bajas de la fecha '. $fecha .'</p>
                                <p>Bajas de empleado(s):</p> 
                                <p>'. 
                                $data
                                .'</p>
								<p>En el siguiente link podra acceder sistema web de empleados</p>
								<center><h2><a href="'.$url.'">Verificar bajas</a></h2></center>
							</body>
						</html>
                        ';
        mail ($correo_destinatario, $asunto, $contenido, $headers, '-f '.$cc.'@mexq.com.mx');
    break;
    default:
    break;
}

?>