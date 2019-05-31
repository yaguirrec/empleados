<?php
    session_start();
    header('Content-Type: text/html');
    // include "inc/function/config.php";
    if (empty($_REQUEST['request']))
        $request = null;
    else
        $request = $_REQUEST['request'];

    $section = $request;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- BOOSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- LOCAL STYLESHEET -->
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/odometer.css">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <link rel="shortcut icon" href="img/whiteLogo2.ico">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <title>Empleados</title>
</head>
<body>
    <?php 
        if (!isset($_SESSION['usuario_nombre']) || empty($_SESSION['usuario_nombre']))
        {
            include 'inc/templates/login.php';
        }
        else
        {
            include 'inc/templates/main.php';
                switch ($request)
                {
                    case 'empleado': case'bajas':
                        include 'inc/templates/empleados/vista.php';
                        break;
                    case 'datos':
                        include 'inc/templates/empleados/vista-empleado.php';
                        break;
                    default:
                        include 'inc/templates/panel/vista.php';
                        break;
                }
            include 'inc/templates/main-footer.php';
        }
    ?>
<!-- FOOTER -->
<?php include 'inc/templates/footer.php'; ?>
</body>
</html>