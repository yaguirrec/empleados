<?php
    header('Content-Type: text/html');
    include "inc/function/config.php";
    if(isset($_GET['request'])){
        $request = explode("/", $_GET['request']);
    }else{
        $request = null;
    }
    echo $request[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- BOOSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo SERVERURL; ?>css/estilos.css">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="shortcut icon" href="<?php echo SERVERURL; ?>img/whiteLogo2.ico">
    <title>Empleados</title>
</head>
<body>
<?php include 'inc/templates/header.php'; ?>
<div class="container">

    <?php 
        switch ($request[0]){
        case 'main':
            include 'inc/templates/' . $request[0] . '.php'; 
            break;
        default:
            include 'inc/templates/login.php';      
            break; 
        } 
    ?>
</div>
<!-- FOOTER -->
<?php include 'inc/templates/footer.php'; ?>
</body>
</html>