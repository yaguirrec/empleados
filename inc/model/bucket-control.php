<?php
session_start();

$action = $_POST['action'];

switch ($action) {
    case 'revisarImagen':
        $empNomina = $_POST['nomina'];
        break;
}
