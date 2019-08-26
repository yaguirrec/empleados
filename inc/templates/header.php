<?php
  error_reporting(0);
  ini_set('display_errors', 1);
  $controlInicio = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Empleados</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/odometer@0.4.8/odometer.min.js"></script>
  <script src="js/level-control.js"></script>
  
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">

  <link rel="shortcut icon" href="img/whiteLogo2.ico">

  
</head>
<?php 
    $emp_level = '';
    $sup_level = '';
    // echo $_SESSION['usuario_nivel'];

    $nombre_usuario = $_SESSION['usuario_nombre'];
    $usuario_activo = $_SESSION['usuario_activo'];
    $nivel_usuario = $_SESSION['usuario_nivel'];
    $usuario_correo = $_SESSION['usuario_correo'];

    if(empty($nivel_usuario) || $nivel_usuario == 1)
      $emp_level = $usuario_activo;
    else
      $sup_level = $usuario_activo;
?>
<input type="hidden" id="nivel_usuario" value="<?php echo $nivel_usuario; ?>" readonly>
<input type="hidden" id="emp_activo" value="<?php echo $emp_level; ?>" readonly>
<input type="hidden" id="sup_activo" value="<?php echo $sup_level; ?>" readonly>
<input type="hidden" id="empleado_activo" value="<?php echo $usuario_activo; ?>" readonly>
<input type="hidden" id="usuario_correo" value="<?php echo $usuario_correo; ?>" readonly>
<body id="page-top">
  <!-- Page Wrapper -->
  
<div id="wrapper">