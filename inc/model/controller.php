<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS");
    
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }

        include 'connection.php';   
        $con = connDB();
        $sesion = false;
        $action  = $_POST['action'];
        
        switch ($action){
        
        case 'login':
            $user = $_POST['usuario'];
            $password = $_POST['clave'];
            $password = hash('sha512', $password);

            $query = "EXEC datos_empleado_acceso @NUMERO_NOMINA = ?"; 

            $params = array($user);//Pasar parametros a las consulta ?

            $stmt = sqlsrv_query( $con, $query, $params );// Asignar parametros al Statement a ejecutar

            if( !$stmt ) {
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'mensaje' => 'Error en la conexión a la BD.'
                );
            }

            //Verificar si la consulta regresa resultados, si el usuario exitse
            if ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) 
            {
                $empleado_status = trim($row['status']);
                if ($empleado_status != 'B')
                {
                    $clave_bd = trim($row['password']);
                    if( strcasecmp($clave_bd, $password) == 0 )
                    {
                        $usuario_activo = trim($row['numero_nomina']);
                        $usuario_nivel = trim($row['nivel']);
                        $usuario_departamento = trim($row['id_area']);
                        $usuario_correo = trim($row['correo']);
                        $usuario_nombre = trim(ucwords(strtolower($row['nombre_largo'])));
                        $sesion = true;

                        $ubicacion = ((empty($usuario_nivel) || $usuario_nivel < 2) ? 'perfil' : 'main');
                        $respuesta = array(
                            'estado' => 'OK',
                            'ubicacion' => $ubicacion,
                            // 'ubicacion' => 'main',
                            'tipo' => 'success',
                            'mensaje' => 'Hola ',
                            'informacion' => 'Bienvenido(a)',
                            'usuario_activo' => $usuario_activo,
                            'usuario_departamento' => $usuario_departamento,
                            'usuario_nombre'    => $usuario_nombre,
                            'usuario_correo'    => $usuario_correo,
                            'usuario_nivel'    => $usuario_nivel,
                            'sesion' => $sesion
                        );
                    }else{
                        $sesion = false;
                        $respuesta = array(
                            'estado' => 'NOK',
                            'tipo' => 'error',
                            'mensaje' => 'Usuario y clave incorrectos.',
                            'informacion' => 'Las credenciales ingresadas no son válidas.',
                            'sesion' => $sesion
                        );
                    }
                //EMPLEADO NO ACTIVO
                }else{
                    $sesion = false;
                        $respuesta = array(
                            'estado' => 'NOK',
                            'tipo' => 'error',
                            'mensaje' => 'Número de nómina inválido',
                            'informacion' => 'Su número de nómina ha sido dado de baja',
                            'sesion' => $sesion
                        );
                }
            }
            //EMPLEADO NO EXISTE
            else 
            {
                $sesion = true;
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'Usuario y clave incorrectos.',
                    'mensaje' => 'Las credenciales ingresadas no son válidas.',
                    'sesion' => $sesion
                    
                );
            }
            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'datos-empleado':
            // die(json_encode($_POST));
            $numero_nomina = $_POST['numero_nomina'];
            $query = "EXEC datos_empleado_consulta @NUMERO_NOMINA = ?";
            $params = array($numero_nomina);//Pasar parametros a las consulta ?
            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de la BD de la Lista'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );

        break;
        case 'mostrar-empleado':
            // die(json_encode($_POST));
            $props = $_POST['prop'];
            $query = "EXEC consulta_datos_empleado ?";

            $params = array($props);//Pasar parametros a las consulta ?
            
            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de la BD de la Lista'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'lista-empleados':
            $props = $_POST['prop'];
            if ($props == 'activos')
            {
                $query = "SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador,
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            WHERE te.status <> 'B' 
                            ORDER BY te.status ASC, te.created_at DESC";
            } 
            else if ($props == 'bajas')
            {
                $query = "SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre,
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador, 
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                            CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja,
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.updated_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            AND te.status = 'B'
                            WHERE NOT EXISTS 
                            (SELECT descripcion FROM tbestado WHERE descripcion = 'bpcdp' AND numero_nomina = te.numero_nomina)
                            ORDER BY te.status ASC, te.updated_at DESC";
            } 

            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'lista-becarios':
            $props = $_POST['prop'];
            
            $query = "SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                        CASE
                            WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                        THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                        ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                        END AS Puesto,
                        CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                        CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja,
                        ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                        FROM tbempleados AS te
                        INNER JOIN tbsucursal AS ts
                        ON te.id_sucursal = ts.id_sucursal 
                        INNER JOIN tbcelula AS tc
                        ON tc.id_celula = te.id_celula
                        INNER JOIN tbarea AS ta
                        ON ta.codigo = tc.codigo_area
                        INNER JOIN tbdatos_empleados AS td
                        ON td.numero_nomina = te.numero_nomina
                        AND td.clasificacion = 'B'
                        ORDER BY te.status ASC, te.created_at DESC";
            
            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'listaBajasPuesto':
        $query = "EXEC bajas_por_puesto";
        
        $stmt = sqlsrv_query( $con, $query);

        $result = array();
        
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
            $respuesta = array(
                'estado' => 'NOK',
                'tipo' => 'error',
                'informacion' => 'No existe informacion',
                'mensaje' => 'No hay datos en la BD'                
            );
        } else {
            do {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                $result[] = $row; 
                }
            } while (sqlsrv_next_result($stmt));
            $respuesta = array(
                'estado' => 'OK',
                'tipo' => 'success',
                'informacion' => $result,
                'mensaje' => 'Informacion obtenida'                
            );
        }

        echo json_encode($respuesta);
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $con );
        break;
        case 'json-empleados':
            $props = $_POST['prop'];
            if ($props == 'activos')
            {
                $query = "SELECT numero_nomina,UPPER(te.nombre_largo) AS Nombre,
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador, 
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            WHERE te.status <> 'B' 
                            ORDER BY te.status ASC, te.created_at DESC";
            } 
            else if ($props == 'bajas')
            {
                $query = "SELECT te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador,
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                            CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja,
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            WHERE te.status = 'B' 
                            ORDER BY te.status ASC, te.created_at DESC";
            } 

            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'altas':
            // die(json_encode($_POST));
            $props = $_POST['prop'];
            $query = "SELECT te.numero_nomina,CONCAT('''',te.nss,td.dv) AS nss,UPPER(te.nombre_largo) AS nombre_largo,
                        td.salario_diario,
                        ts.nombre AS sucursal,
                        tc.nombre planta,
                        CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                        td.registro_patronal,
                        CASE WHEN td.nomina = 'S' THEN 'SEM'
                        WHEN td.nomina = 'Q' THEN 'QUIN'
                        ELSE 'NA' END AS tipo_nomina,
                        CASE
                            WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
			    THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
			    ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                        END AS puesto,
                        td.lote,td.lote_acuse,te.created_at
                        FROM tbempleados AS te
                        INNER JOIN tbsucursal AS ts
                        ON te.id_sucursal = ts.id_sucursal 
                        INNER JOIN tbcelula AS tc
                        ON tc.id_celula = te.id_celula
                        INNER JOIN tbarea AS ta
                        ON ta.codigo = tc.codigo_area
                        INNER JOIN tbdatos_empleados AS td
                        ON te.numero_nomina = td.numero_nomina
                        WHERE te.status <> 'B' AND te.fecha_alta = ? AND td.clasificacion <> 'B'
                        GROUP BY te.numero_nomina,te.numero_nomina,te.nss,td.dv,te.nombre_largo,td.salario_diario,ts.nombre,tc.nombre,te.fecha_alta,td.registro_patronal,td.nomina,td.lote,te.created_at,te.puesto_temp,te.id_puesto,td.lote_acuse,te.status
                        ORDER BY te.status ASC, te.created_at DESC";

            $params = array($props);

            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();

            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de buscar'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );

        break;
        case 'altas-semanales':
        // die(json_encode($_POST));
        $fechaINI = $_POST['fechaINI'];
        $fechaFIN = $_POST['fechaFIN'];

        $query = "EXEC altasSemanales ?,?";

        $params = array($fechaINI, $fechaFIN);

        $stmt = sqlsrv_query( $con, $query, $params);

        $result = array();

        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
            $respuesta = array(
                'estado' => 'NOK',
                'tipo' => 'error',
                'informacion' => 'No existe informacion',
                'mensaje' => 'No hay datos en la BD'                
            );
        } else {
            do {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                $result[] = $row; 
                }
            } while (sqlsrv_next_result($stmt));
            $respuesta = array(
                'estado' => 'OK',
                'tipo' => 'success',
                'informacion' => $result,
                'mensaje' => 'Informacion obtenida de buscar'                
            );
        }


        echo json_encode($respuesta);
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $con );
        break;
        case 'envioAcuse':
            // die(json_encode($_POST));
            $arrNomina = $_POST['arrNomina'];
            $arrNomina_ = str_replace("|", "','", $arrNomina);
            $nombreAdjuntoAcuse = $_POST['nombreAdjuntoAcuse'];
            
            $update = "UPDATE tbdatos_empleados SET lote_acuse = '".$nombreAdjuntoAcuse."' WHERE numero_nomina IN ('".$arrNomina_."');";

            $stmt = sqlsrv_query( $con, $update);

            if( $stmt ) {
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => 'Datos actualizados',
                    'mensaje' => 'Lote actualizado'                  
                );
            } else {            
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'             
                );
            }
                         
            echo json_encode($respuesta);
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($con);
        break;
        case 'envioProcesada':
            // die(json_encode($_POST));
            $arrNomina = $_POST['arrNomina'];
            $arrNomina_ = str_replace("|", "','", $arrNomina);
            $nombreAdjuntoProcesada = $_POST['nombreAdjuntoProcesada'];
            
            $update = "UPDATE tbdatos_empleados SET lote = '".$nombreAdjuntoProcesada."' WHERE numero_nomina IN ('".$arrNomina_."');";

            $stmt = sqlsrv_query( $con, $update);

            if( $stmt ) {
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => 'Datos actualizados',
                    'mensaje' => 'Lote Procesada actualizado'                  
                );
            } else {            
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'             
                );
            }
                         
            echo json_encode($respuesta);
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($con);
        break;
        case 'envioAcuseBaja':
            // die(json_encode($_POST));
            $arrNomina = $_POST['arrNomina'];
            $arrNomina_ = str_replace("|", "','", $arrNomina);
            $nombreAdjuntoAcuse = $_POST['nombreAdjuntoAcuse'];
            
            $update = "UPDATE tbdatos_empleados SET baja_acuse = '".$nombreAdjuntoAcuse."' WHERE numero_nomina IN ('".$arrNomina_."');";

            $stmt = sqlsrv_query( $con, $update);

            if( $stmt ) {
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => 'Datos actualizados',
                    'mensaje' => 'Lote actualizado'                  
                );
            } else {            
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'             
                );
            }
                         
            echo json_encode($respuesta);
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($con);
        break;
        case 'envioProcesadaBaja':
            // die(json_encode($_POST));
            $arrNomina = $_POST['arrNomina'];
            $arrNomina_ = str_replace("|", "','", $arrNomina);
            $nombreAdjuntoProcesada = $_POST['nombreAdjuntoProcesada'];
            
            $update = "UPDATE tbdatos_empleados SET baja_procesada = '".$nombreAdjuntoProcesada."' WHERE numero_nomina IN ('".$arrNomina_."');";

            $stmt = sqlsrv_query( $con, $update);

            if( $stmt ) {
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => 'Datos actualizados',
                    'mensaje' => 'Lote Procesada actualizado'                  
                );
            } else {            
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'             
                );
            }
                         
            echo json_encode($respuesta);
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($con);
        break;
        case 'bajas':
            // die(json_encode($_POST));
            $props = $_POST['prop'];
            $query = "EXEC bajas_diarias ?";

            $params = array($props);

            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();

            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de buscar'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        case 'cambioFechaBaja':
            die(json_encode($_POST));
            $props = $_POST['prop'];
            $query = "EXEC bajas_diarias ?";

            $params = array($props);

            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();

            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de buscar'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );

        break;
        case 'buscar-texto':
            // die(json_encode($_POST));
            $txtBuscado = $_POST['txtBuscado'];
            $props = $_POST['prop'];

            if ($props == 'activos')
            {
                $query = "SELECT te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador,
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            WHERE te.status <> 'B' ";
                            if (empty($valorBuscado)){ 
                                $query .= "AND (te.numero_nomina LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR te.nombre_largo LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR ts.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR ta.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR tc.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%'
                                            OR te.created_at LIKE '%' + CONVERT(NVARCHAR, ?) + '%')";
                            }
                            
                            $query .= "ORDER BY te.status ASC, te.created_at DESC";
            } 
            else 
            {
                $query = "SELECT TOP 250 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
								WHEN td.tabulador IS NULL THEN 'NA'
								ELSE REPLACE(td.tabulador,'|','') 
							END AS tabulador,
                            CASE
                                WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
                                THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            END AS Puesto,
                            CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                            CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja,
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            INNER JOIN tbdatos_empleados AS td
							ON td.numero_nomina = te.numero_nomina
                            WHERE te.status = 'B'";
                            if (empty($valorBuscado)){ 
                                $query .= "AND (te.numero_nomina LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR te.nombre_largo LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR ts.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR ta.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%' OR tc.nombre LIKE '%' + CONVERT(NVARCHAR, ?) + '%'
                                            OR te.created_at LIKE '%' + CONVERT(NVARCHAR, ?) + '%')";
                            }
                            $query .= "ORDER BY te.status ASC, te.fecha_alta DESC";
            }
            $params = array($txtBuscado,$txtBuscado,$txtBuscado,$txtBuscado,$txtBuscado,$txtBuscado);

            $stmt = sqlsrv_query( $con, $query, $params);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de buscar'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        //BAJA DEL EMPLEADO
        case 'claBajas':
            // die(json_encode($_POST));
            $param = $_POST['param'];
            $key = $_POST['key'];
            if($param == 'clasificacion')
                $query = "SELECT codigo,descripcion FROM tbcodigos WHERE codigo LIKE '%CLAB' ORDER BY id_codigo ASC";
            else if($param == 'motivo')
                $query = "SELECT codigo,descripcion FROM tbcodigos WHERE codigo LIKE '".$key."MOT%' AND codigo NOT LIKE '%CLAB' ORDER BY id_codigo ASC";
            else if($param == 'explicacion' && strlen($key) == 2)
                $query = "SELECT codigo,descripcion FROM tbcodigos WHERE codigo LIKE '0%".$key."EXP%' AND codigo NOT LIKE '%CLAB' ORDER BY id_codigo ASC";
            else if($param == 'explicacion' && strlen($key) == 1)
                $query = "SELECT codigo,descripcion FROM tbcodigos WHERE codigo LIKE '00%".$key."EXP%' AND codigo NOT LIKE '%CLAB' ORDER BY id_codigo ASC";
                
            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        break;
        //BAJA DEL EMPLEADO
        case 'highlights':
            // die(json_encode($_POST));
            $query = "SELECT COUNT(*) AS cifras FROM tbempleados WHERE status <> 'B' UNION ALL
                        SELECT COUNT(*) AS totalEmpleadosAdministrativos FROM tbempleados WHERE area_temp LIKE '99COR%' AND status <> 'B' UNION ALL
                        SELECT COUNT(*) AS totalEmpleadosOperativos FROM tbempleados WHERE area_temp NOT LIKE '99COR%' AND status <> 'B' UNION ALL
                        SELECT COUNT(*) AS totalEmpleadosActuales FROM tbempleados WHERE YEAR(fecha_alta) >= YEAR(GETDATE()) AND status <> 'B' UNION ALL
                        select COUNT(*) AS totalSucursales from tbsucursal where codigo NOT IN ('000000000','99CON0000','99COR0000')";
                           
            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de high'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
        case 'obtener-empleados-mes':
            // die(json_encode($_POST));
            $props = $_POST['props'];
            if($props == 'bajas'){
                $query = "SELECT COUNT (*) AS contador,
                            UPPER(FORMAT(fecha_baja, 'MMMM', 'es-es')) AS 'nombre_mes',
                            MONTH(fecha_baja) AS mes
                            FROM tbempleados
                            WHERE YEAR(fecha_baja) = YEAR(GETDATE())
                            GROUP BY MONTH(fecha_baja), FORMAT(fecha_baja, 'MMMM', 'es-es')
                            ORDER BY MONTH(fecha_baja) ASC;";
            } else {
                $query = "SELECT COUNT (*) AS contador,
                            UPPER(FORMAT(fecha_alta, 'MMMM', 'es-es')) AS 'nombre_mes',
                            MONTH(fecha_alta) AS mes
                            FROM tbempleados
                            WHERE YEAR(fecha_alta) = YEAR(GETDATE())
                            GROUP BY MONTH(fecha_alta), FORMAT(fecha_alta, 'MMMM', 'es-es')
                            ORDER BY MONTH(fecha_alta) ASC;";
            }
                           

            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de empleados'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
        case 'obtener-datos-empleados':
            // die(json_encode($_POST));

            $query = "SELECT 
                        SUM(CASE WHEN YEAR(fecha_alta)= YEAR(GETDATE()) AND status <> 'B' THEN 1 ELSE 0 END) AS altas,
                        SUM(CASE WHEN YEAR(fecha_baja)= YEAR(GETDATE()) AND status = 'B' THEN 1 ELSE 0 END) AS bajas
                        FROM tbempleados;";
                           
            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de surcusales'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
        case 'obtener-datos-sucursales':
            // die(json_encode($_POST));

            $query = "SELECT SUBSTRING(area_temp,3,3) AS sucursal,COUNT (*) AS cantidad
                        FROM tbempleados
                        WHERE SUBSTRING(area_temp,3,3) <> '' AND status <> 'B'
                        GROUP BY SUBSTRING(area_temp,3,3)
                        ORDER BY cantidad DESC;";
                           
            $stmt = sqlsrv_query( $con, $query);

            $result = array();
            
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
                $respuesta = array(
                    'estado' => 'NOK',
                    'tipo' => 'error',
                    'informacion' => 'No existe informacion',
                    'mensaje' => 'No hay datos en la BD'                
                );
            } else {
                do {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                    $result[] = $row; 
                    }
                } while (sqlsrv_next_result($stmt));
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'success',
                    'informacion' => $result,
                    'mensaje' => 'Informacion obtenida de surcusales'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
            case 'lista-direcciones':
                // die(json_encode($_POST));
                $query = "SELECT * FROM VW_empleados_direcciones ORDER BY fecha_alta DESC";
                
                $stmt = sqlsrv_query( $con, $query);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'fecha':
                // die(json_encode($_POST));
                $props = $_POST['prop'];
                $mes = $_POST['mes'];
                
                if ($props == 'cumple')
                {
                    $query = "SELECT te.numero_nomina, te.nombre_largo, 
                                CASE
                                    WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                    THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                    ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                END AS Puesto,
                                ts.nombre AS 'Sucursal',
                                ta.nombre AS 'Departamento', 
                                tc.nombre AS 'Celula',
                                CONVERT(VARCHAR(10), te.fecha_nacimiento, 105) AS fecha,
                                DATEDIFF(YY, fecha_nacimiento, GETDATE()) - 
                                CASE WHEN RIGHT(CONVERT(VARCHAR(6), GETDATE(), 12), 4) >= 
                                        RIGHT(CONVERT(VARCHAR(6), fecha_nacimiento, 12), 4) 
                                THEN 0 ELSE 1 END AS field1,
                                CASE 
                                WHEN 
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE()) AS VARCHAR) + '-' + CAST(MONTH(fecha_nacimiento) AS VARCHAR) + '-' + CAST(DAY(fecha_nacimiento) AS VARCHAR)) < 1 
                                    THEN
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE())+1 AS VARCHAR) + '-' + CAST(MONTH(fecha_nacimiento) AS VARCHAR) + '-' + CAST(DAY(fecha_nacimiento) AS VARCHAR))
                                    ELSE
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE()) AS VARCHAR) + '-' + CAST(MONTH(fecha_nacimiento) AS VARCHAR) + '-' + CAST(DAY(fecha_nacimiento) AS VARCHAR))
                                    END AS diasFaltantes
                                FROM tbempleados AS te
                                INNER JOIN tbsucursal AS ts
                                ON te.id_sucursal = ts.id_sucursal
                                INNER JOIN tbcelula AS tc
                                ON tc.id_celula = te.id_celula
                                INNER JOIN tbarea AS ta
                                ON tc.codigo_area = ta.codigo
                                WHERE te.status <> 'B' AND MONTH(fecha_nacimiento) = ?
                                ORDER BY MONTH(fecha_nacimiento),DAY(fecha_nacimiento) ASC";
                }elseif($props == 'antig'){
                    $query = "SELECT te.numero_nomina, te.nombre_largo, 
                                CASE
                                    WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                    THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                    ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                                END AS Puesto,
                                ts.nombre AS 'Sucursal',
                                ta.nombre AS 'Departamento', 
                                tc.nombre AS 'Celula',
                                CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fecha,
                                DATEDIFF(YY, fecha_alta, GETDATE()) - 
                                CASE WHEN RIGHT(CONVERT(VARCHAR(6), GETDATE(), 12), 4) >= 
                                        RIGHT(CONVERT(VARCHAR(6), fecha_alta, 12), 4) 
                                THEN 0 ELSE 1 END AS field1,
                                CASE 
                                WHEN 
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE()) AS VARCHAR) + '-' + CAST(MONTH(fecha_alta) AS VARCHAR) + '-' + CAST(DAY(fecha_alta) AS VARCHAR)) < 1 
                                    THEN
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE())+1 AS VARCHAR) + '-' + CAST(MONTH(fecha_alta) AS VARCHAR) + '-' + CAST(DAY(fecha_alta) AS VARCHAR))
                                    ELSE
                                    DATEDIFF(DAY, GETDATE(),CAST(YEAR(GETDATE()) AS VARCHAR) + '-' + CAST(MONTH(fecha_alta) AS VARCHAR) + '-' + CAST(DAY(fecha_alta) AS VARCHAR))
                                    END AS diasFaltantes
                                FROM tbempleados AS te                                
                                INNER JOIN tbsucursal AS ts
                                ON te.id_sucursal = ts.id_sucursal
                                INNER JOIN tbcelula AS tc
                                ON tc.id_celula = te.id_celula
                                INNER JOIN tbarea AS ta
                                ON tc.codigo_area = ta.codigo
                                WHERE 
                                te.status <> 'B' AND MONTH(fecha_alta) = ?
                                ORDER BY MONTH(fecha_alta),DAY(fecha_alta) ASC";
                }    

                $params = array($mes);

                $stmt = sqlsrv_query( $con, $query, $params);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'buscarSucursal':
                // die(json_encode($_POST));
                $query = "SELECT id_sucursal,codigo,nombre FROM tbsucursal ORDER BY nombre ASC";
                
                $stmt = sqlsrv_query( $con, $query);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'buscarNomina':
                // die(json_encode($_POST));
                $query = "SELECT code_value,code_value_desc FROM PJCODE WHERE code_type = 'FFA' ORDER BY code_value ASC";
                
                $stmt = sqlsrv_query( $con, $query);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'buscarCelula':
                // die(json_encode($_POST));
                $sucursal =  $_POST['sucursal'];
                $clasificacion =  $_POST['clasificacion'];
                if ($clasificacion === 'A'){
                    $query = "SELECT tc.id_celula,tc.codigo,tc.nombre FROM tbcelula AS tc
                                INNER JOIN tbsucursal AS ts
                                ON SUBSTRING(tc.codigo,1,5) = SUBSTRING(ts.codigo,1,5)
                                WHERE SUBSTRING(tc.codigo,1,5) = '99COR'";

                    $stmt = sqlsrv_query( $con, $query);
                    
                } else {
                    $query = "SELECT tc.id_celula,tc.codigo,tc.nombre FROM tbcelula AS tc
                                INNER JOIN tbsucursal AS ts
                                ON SUBSTRING(tc.codigo,1,5) = SUBSTRING(ts.codigo,1,5)";
                    $params = array($sucursal);
                    $stmt = sqlsrv_query( $con, $query);
                }


                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'buscarP':
                // die(json_encode($_POST));
                $param = $_POST['param'];
                $clasificacion = $_POST['clasificacion'];
                if ($clasificacion === 'A'){
                    $query = "SELECT id_puesto,nombre FROM tbpuesto WHERE id_celula = ? ORDER BY id_nivel ASC";
                    
                    $params = array($param);

                    $stmt = sqlsrv_query( $con, $query, $params);
                } else if($clasificacion === 'B'){
                    $query = "SELECT id_puesto,nombre FROM tbpuesto WHERE id_nivel > 8";
                    

                    $stmt = sqlsrv_query( $con, $query, $params);
                }
                else{
                    $query = "SELECT id_puesto,nombre FROM tbpuesto ORDER BY id_nivel ASC";
                    
                    $stmt = sqlsrv_query( $con, $query);

                }
               

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            //OBTENER LAS SUCURSALES PARA EL TABULADOR
            case 'sucursalTabulador':
                //die(json_encode($_POST));
                $query = "SELECT RTRIM(code_value) AS code_value FROM PJCODE WHERE code_type = 'SUC' AND code_value <> '000' ORDER BY code_type";

                $stmt = sqlsrv_query( $con, $query);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'buscarJefe':
                // die(json_encode($_POST));
                $param = $_POST['param'];
                $param2 = $_POST['param2'];

                $query = "SELECT tp.id_nivel,tp.id_puesto,tp.nombre,UPPER(te.nombre_largo) as nombre_largo,te.numero_nomina FROM 
                            tbpuesto AS tp
                            INNER JOIN tbempleados AS te
                            ON tp.id_puesto = te.id_puesto
                            INNER JOIN tbcelula AS tc
                            ON te.id_celula = tc.id_celula
                            INNER JOIN tbarea AS ta
                            ON tc.codigo_area = ta.codigo
                            AND tp.id_nivel < (SELECT id_nivel FROM tbpuesto WHERE id_puesto = ?)
                            AND (tp.id_celula = (SELECT id_celula FROM tbpuesto WHERE id_puesto = ?)) 
                            AND te.status <> 'B'
                            UNION ALL
                            SELECT tp.id_nivel,tp.id_puesto,tp.nombre,UPPER(te.nombre_largo) as nombre_largo,te.numero_nomina FROM tbpuesto AS tp
                            INNER JOIN tbempleados AS te
                            ON tp.id_puesto = te.id_puesto
                            INNER JOIN (SELECT id_celula FROM tbcelula WHERE codigo_area =
                            (SELECT area_superior FROM tbarea WHERE codigo = (SELECT codigo_area FROM tbcelula WHERE id_celula = ?)))
                            AS temp
                            ON temp.id_celula = tp.id_celula
                            ORDER BY id_nivel";
                
                $params = array($param,$param,$param2);

                $stmt = sqlsrv_query( $con, $query, $params);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'validaReingreso':
                //die(json_encode($_POST));
                $curp =  $_POST['curp'];
                $query = "SELECT te.numero_nomina,te.nombre_largo,RIGHT(descripcion,1) as controlReingreso FROM tbempleados AS te
                            INNER JOIN tbestado as ts
                            ON te.numero_nomina = ts.numero_nomina
                            WHERE CONCAT(curpini + RIGHT(YEAR(fecha_nacimiento),2) , FORMAT(fecha_nacimiento,'MM') , CONVERT(CHAR(2),fecha_nacimiento,103) , curpfin) = ?";

                $params = array($curp);
                
                $stmt = sqlsrv_query( $con, $query, $params);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'obtenerNomina':
                $query = "SELECT MAX(CAST(numero_nomina AS INT)) AS numeroNomina FROM tbempleados";

                $stmt = sqlsrv_query( $con, $query);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'guardarEmpleado':
                 //die(json_encode($_POST));
                    $nomina =  $_POST['nomina'];
                    $jefeNomina =  $_POST['jefenomina'];
                    $claveTabulador =  $_POST['claveTabulador'];
                    $nombre =  $_POST['nombre'];
                    $aPaterno =  $_POST['aPaterno'];
                    $aMaterno =  $_POST['aMaterno'];
                    $nombreLargo = $_POST['nombreLargo'];
                    $genero =  $_POST['genero'];
                    $curpini =  $_POST['curpini'];
                    $curpfin =  $_POST['curpfin'];
                    $rfcini =  $_POST['rfcini'];
                    $rfcfin =  $_POST['rfcfin'];
                    $nss =  $_POST['nss'];
                    $fechaNacimiento =  $_POST['fechaNacimiento'];
                    $fechaAlta =  $_POST['fechaAlta'];
                    $fechaBaja =  '1990-01-01';
                    $status =  'A';
                    $sucursal =  $_POST['sucursal'];
                    $area =  0;
                    $celula =  $_POST['celula'];
                    $puesto =  $_POST['puesto'];
                    $comentario =  $_POST['comentario'];

                    $clasificacion =  $_POST['clasificacion'];
                    $salarioDiario =  $_POST['salarioDiario'];
                    $salarioMensual =  $_POST['salarioMensual'];
                    $tipoNomina =  $_POST['tipoNomina'];
                    $registro =  $_POST['registro'];
                    $lote =  '';
                    $dv =  $_POST['dv'];
                    $lNacimiento =  $_POST['lNacimiento'];
                    $tIdentificacion =  $_POST['tIdentificacion'];
                    $id =  $_POST['id'];
                    $eCivil =  $_POST['eCivil'];
                    $escolaridad =  $_POST['escolaridad'];
                    $cEscolaridad =  $_POST['cEscolaridad'];
                    $nPadre =  $_POST['nPadre'];
                    $nMadre =  $_POST['nMadre'];
                    $calle =  $_POST['calle'];
                    $numE =  $_POST['numE'];
                    $numI =  $_POST['numI'];
                    $fraccionamiento =  $_POST['fraccionamiento'];
                    $domicilio =  $_POST['domicilio'];
                    $cp =  $_POST['cp'];
                    $edo =  $_POST['edo'];
                    $municipio =  $_POST['municipio'];
                    $localidad =  $_POST['localidad'];
                    $infonavit =  $_POST['infonavit'];
                    $nInfonavit =  $_POST['nInfonavit'];
                    $fonacot =  $_POST['fonacot'];
                    $nFonacot =  $_POST['nFonacot'];
                    $banco =  $_POST['banco'];
                    $cuenta =  $_POST['cuenta'];
                    $correo =  $_POST['correo'];
                    $telefono =  $_POST['telefono'];
                    $celular =  $_POST['celular'];
                    $contacto =  $_POST['contacto'];
                    $nContacto =  $_POST['nContacto'];
                    $posicion =  0;
                    $empleado_activo = $_POST['empleado_activo'];


                    $fechaControl =  date('Y-m-d H:i:s');
                    
                    $insert = "EXEC insertEmployeeData @nnomina = ?, 
                                                        @jnomina = ?,
                                                        @codigo_tabulador = ?,
                                                        @nlargo = ?, 
                                                        @nombre = ?,
                                                        @apaterno = ?,
                                                        @amaterno = ?,
                                                        @sexo = ?,
                                                        @curpi = ?,
                                                        @curpf = ?,
                                                        @rfcini = ?,
                                                        @rfcfin = ?,
                                                        @nss = ?,
                                                        @fechan = ?,
                                                        @fechaa = ?,
                                                        @fechab = ?,
                                                        @status = ?,
                                                        @ids = ?,
                                                        @ida = ?,
                                                        @idc = ?,
                                                        @idp = ?,
                                                        @clasificacion  = ?,
                                                        @salarioDiario  = ?,
                                                        @salarioMensual  = ?,
                                                        @nomina  = ?,
                                                        @comentario  = ?,
                                                        @registro_patronal  = ?,
                                                        @lote  = ?,
                                                        @dv  = ?,
                                                        @lugar_nacimiento  = ?,
                                                        @identificacion  = ?,
                                                        @numero_identificacion  = ?,
                                                        @estado_civil  = ?,
                                                        @escolaridad  = ?,
                                                        @constancia  = ?,
                                                        @nombre_padre  = ?,
                                                        @nombre_madre  = ?,
                                                        @calle  = ?,
                                                        @numero_exterior  = ?,
                                                        @numero_interior  = ?,
                                                        @fraccionamiento  = ?,
                                                        @domicilio_completo  = ?,
                                                        @codigo_postal  = ?,
                                                        @estado  = ?,
                                                        @municipio  = ?,
                                                        @localidad  = ?,
                                                        @infonavit  = ?,
                                                        @numero_infonavit  = ?,
                                                        @fonacot  = ?,
                                                        @numero_fonacot  = ?,
                                                        @cuenta  = ?,
                                                        @numero_cuenta  = ?,
                                                        @correo  = ?,
                                                        @telefono  = ?,
                                                        @celular  = ?,
                                                        @contacto_emergencia_nombre  = ?,
                                                        @contacto_emergencia_numero  = ?,
                                                        @posicion = ?,
                                                        @nominaControl = ?";


                    $params = array($nomina,$jefeNomina,$claveTabulador,$nombreLargo,$nombre,$aPaterno,$aMaterno,$genero,$curpini,$curpfin,$rfcini,$rfcfin,$nss,$fechaNacimiento,$fechaAlta,$fechaBaja,$status,$sucursal,$area,$celula,$puesto,
                                    $clasificacion,$salarioDiario,$salarioMensual,$tipoNomina,$comentario,$registro,$lote,$dv,$lNacimiento,$tIdentificacion,$id,$eCivil,$escolaridad,$cEscolaridad,$nPadre,$nMadre,$calle,$numE,$numI,$fraccionamiento,
                                    $domicilio,$cp,$edo,$municipio,$localidad,$infonavit,$nInfonavit,$fonacot,$nFonacot,$banco,$cuenta,$correo,$telefono,$celular,$contacto,$nContacto,$posicion,$empleado_activo);
                    
                    $stmt = sqlsrv_query( $con, $insert, $params);

                    if( $stmt ) {
                        $respuesta = array(
                            'estado' => 'OK',
                            'tipo' => 'success',
                            'informacion' => 'Insertado',
                            'mensaje' => 'Informacion obtenida'                  
                        );
                    } 
                    else {
                        $respuesta = array(
                            'estado' => 'NOK',
                            'tipo' => 'error',
                            'informacion' => 'No existe informacion',
                            'mensaje' => 'No hay datos en la BD'             
                        );
                    }               

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'modificarEmpleado':
                // die(json_encode($_POST));
                    $nomina =  $_POST['nomina'];
                    $jefeNomina =  $_POST['jefenomina'];
                    $claveTabulador =  $_POST['claveTabulador'];
                    $nombre =  $_POST['nombre'];
                    $aPaterno =  $_POST['aPaterno'];
                    $aMaterno =  $_POST['aMaterno'];
                    $nombreLargo = $_POST['nombreLargo'];
                    $nss =  $_POST['nss'];
                    $fechaAlta =  $_POST['fechaAlta'];
                    $empleado_status =  $_POST['empleado_status'];
                    $sucursal =  $_POST['sucursal'];
                    $area =  0;
                    $celula =  $_POST['celula'];
                    $puesto =  $_POST['puesto'];
                    $comentario =  $_POST['comentario'];

                    $genero =  $_POST['genero'];
                    $curpini =  $_POST['curpini'];
                    $curpfin =  $_POST['curpfin'];
                    $rfcini =  $_POST['rfcini'];
                    $rfcfin =  $_POST['rfcfin'];
                    $fechaNacimiento =  $_POST['fechaNacimiento'];

                    $clasificacion =  $_POST['clasificacion'];
                    $salarioDiario =  $_POST['salarioDiario'];
                    $salarioMensual =  $_POST['salarioMensual'];
                    $tipoNomina =  $_POST['tipoNomina'];
                    $registro =  $_POST['registro'];
                    $lote =  $_POST['lote'];;
                    $dv =  $_POST['dv'];
                    $lNacimiento =  $_POST['lNacimiento'];
                    $tIdentificacion =  $_POST['tIdentificacion'];
                    $id =  $_POST['id'];
                    $eCivil =  $_POST['eCivil'];
                    $escolaridad =  $_POST['escolaridad'];
                    $cEscolaridad =  $_POST['cEscolaridad'];
                    $nPadre =  $_POST['nPadre'];
                    $nMadre =  $_POST['nMadre'];
                    $calle =  $_POST['calle'];
                    $numE =  $_POST['numE'];
                    $numI =  $_POST['numI'];
                    $fraccionamiento =  $_POST['fraccionamiento'];
                    $domicilio =  $_POST['domicilio'];
                    $cp =  $_POST['cp'];
                    $edo =  $_POST['edo'];
                    $municipio =  $_POST['municipio'];
                    $localidad =  $_POST['localidad'];
                    $infonavit =  $_POST['infonavit'];
                    $nInfonavit =  $_POST['nInfonavit'];
                    $fonacot =  $_POST['fonacot'];
                    $nFonacot =  $_POST['nFonacot'];
                    $banco =  $_POST['banco'];
                    $cuenta =  $_POST['cuenta'];
                    $correo =  $_POST['correo'];
                    $telefono =  $_POST['telefono'];
                    $celular =  $_POST['celular'];
                    $contacto =  $_POST['contacto'];
                    $nContacto =  $_POST['nContacto'];
                    $empleado_activo = $_POST['empleado_activo'];

                    $insert = "EXEC updateEmployeeData @nnomina = ?, 
                                                        @jnomina = ?,
                                                        @codigo_tabulador = ?,
                                                        @nlargo = ?, 
                                                        @nombre = ?,
                                                        @apaterno = ?,
                                                        @amaterno = ?,
                                                        @sexo = ?,
                                                        @curpi = ?,
                                                        @curpf = ?,
                                                        @rfcini = ?,
                                                        @rfcfin = ?,
                                                        @fechan = ?,
                                                        @nss = ?,
                                                        @fechaa = ?,
                                                        @empleado_status = ?,
                                                        @ids = ?,
                                                        @ida = ?,
                                                        @idc = ?,
                                                        @idp = ?,
                                                        @clasificacion  = ?,
                                                        @salarioDiario  = ?,
                                                        @salarioMensual  = ?,
                                                        @nomina  = ?,
                                                        @comentario  = ?,
                                                        @registro_patronal  = ?,
                                                        @lote  = ?,
                                                        @dv  = ?,
                                                        @lugar_nacimiento  = ?,
                                                        @identificacion  = ?,
                                                        @numero_identificacion  = ?,
                                                        @estado_civil  = ?,
                                                        @escolaridad  = ?,
                                                        @constancia  = ?,
                                                        @nombre_padre  = ?,
                                                        @nombre_madre  = ?,
                                                        @calle  = ?,
                                                        @numero_exterior  = ?,
                                                        @numero_interior  = ?,
                                                        @fraccionamiento  = ?,
                                                        @domicilio_completo  = ?,
                                                        @codigo_postal  = ?,
                                                        @estado  = ?,
                                                        @municipio  = ?,
                                                        @localidad  = ?,
                                                        @infonavit  = ?,
                                                        @numero_infonavit  = ?,
                                                        @fonacot  = ?,
                                                        @numero_fonacot  = ?,
                                                        @cuenta  = ?,
                                                        @numero_cuenta  = ?,
                                                        @correo  = ?,
                                                        @telefono  = ?,
                                                        @celular  = ?,
                                                        @contacto_emergencia_nombre  = ?,
                                                        @contacto_emergencia_numero  = ?,
                                                        @nominaControl = ?";


                    $params = array($nomina,$jefeNomina,$claveTabulador,$nombreLargo,$nombre,$aPaterno,$aMaterno,$genero,$curpini,$curpfin,$rfcini,$rfcfin,$fechaNacimiento,$nss,$fechaAlta,$empleado_status,$sucursal,$area,$celula,$puesto,$clasificacion,$salarioDiario,$salarioMensual,$tipoNomina,
                                    $comentario,$registro,$lote,$dv,$lNacimiento,$tIdentificacion,$id,$eCivil,$escolaridad,$cEscolaridad,$nPadre,$nMadre,$calle,$numE,$numI,$fraccionamiento,
                                    $domicilio,$cp,$edo,$municipio,$localidad,$infonavit,$nInfonavit,$fonacot,$nFonacot,$banco,$cuenta,$correo,$telefono,$celular,$contacto,$nContacto,$empleado_activo);
                    
                    $stmt = sqlsrv_query( $con, $insert, $params);

                    if( $stmt ) {
                        $respuesta = array(
                            'estado' => 'OK',
                            'tipo' => 'success',
                            'informacion' => 'Insertado',
                            'mensaje' => 'Informacion obtenida'                  
                        );
                    } 
                    else {
                        $respuesta = array(
                            'estado' => 'NOK',
                            'tipo' => 'error',
                            'informacion' => 'No existe informacion',
                            'mensaje' => 'No hay datos en la BD'             
                        );
                    }               

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'bajaEmpleado':
                // die(json_encode($_POST));
                $nominaEmpleado =  $_POST['nominaEmpleado'];
                $razonBaja =  $_POST['razonBaja'];
                $comentariosBaja =  $_POST['comentariosBaja'];
                $fechaBaja =  $_POST['fechaBaja'];
                $empleadoControl =  $_POST['empleadoControl'];

                $update = "EXEC firedEmployee @numeroNomina = ?,
                                                @descripcion = ?,
                                                @comentario = ?,
                                                @fechaBaja = ?,
                                                @nominaControl = ?";

                $params = array($nominaEmpleado,$razonBaja,$comentariosBaja,$fechaBaja,$empleadoControl);

                $stmt = sqlsrv_query( $con, $update, $params);

                if( $stmt ) {
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => 'Baja',
                        'mensaje' => 'Baja del empleado realizada'                  
                    );
                } 
                else {
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'             
                    );
                }               

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'obtenerTipoPuesto':
                // die(json_encode($_POST));
                $query = "SELECT id_puesto,nivel,nombre FROM tbtipopuesto WHERE id_puesto > 1  ORDER BY id_puesto DESC";
                
                $stmt = sqlsrv_query( $con, $query);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }               

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con ); 
            break;
            case 'obtenerDepartamento':
                // die(json_encode($_POST));
                $query = "SELECT id_celula,UPPER(nombre) AS nombre FROM tbcelula WHERE codigo LIKE '99COR%' OR id_celula = 5 ORDER BY codigo";
                
                $stmt = sqlsrv_query( $con, $query);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }               

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con ); 
            break;
            case 'guardarPuesto':
                //die(json_encode($_POST));
                $puestoNombre =  $_POST['puestoNombre'];
                $puestoDepartamento =  $_POST['puestoDepartamento'];
                $puestoDescripcion =  $_POST['puestoDescripcion'];
                $puestoNivel =  $_POST['puestoNivel'];
                $empleadoControl = $_POST['empleadoControl'];
                $puestoCorto = $_POST['puestoCorto'];
                $puestoJefe = 2;
                $hoy = date("Y-m-d H:m:s");  

                $query = "SELECT CONCAT('P',MAX( id_puesto )) AS nuevoCodigo FROM tbpuesto";

                $stmnt = sqlsrv_query( $con, $query);

                if ($row = sqlsrv_fetch_array( $stmnt, SQLSRV_FETCH_ASSOC)) {
                    $codigoPuesto = trim($row['nuevoCodigo']);
                }

                $insert = "INSERT INTO tbpuesto
                        ([codigo]
                        ,[nombre]
                        ,[descripcion]
                        ,[nombre_corto]
                        ,[id_nivel]
                        ,[id_puestojefe]
                        ,[id_celula]
                        ,[id_clasificacion]
                        ,[created_at]
                        ,[created_by])
                VALUES
                        (?,?,?,?,?,?,?,?,?,?)";

                $params = array($codigoPuesto,$puestoNombre,$puestoDescripcion,$puestoCorto,$puestoNivel,$puestoJefe,$puestoDepartamento,$puestoNivel,$hoy,$empleadoControl);
            
                $stmt = sqlsrv_query( $con, $insert, $params);

                if( $stmt ) {
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => 'Insertado',
                        'mensaje' => 'Informacion obtenida'                  
                    );
                } 
                else {
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => $codigoPuesto,
                        'mensaje' => 'No hay datos en la BD'             
                    );
                }               

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
            case 'actualizarPuesto':
                //die(json_encode($_POST));
                $puestoNombre =  $_POST['puestoNombre'];
                $puestoDepartamento =  $_POST['puestoDepartamento'];
                $puestoDescripcion =  $_POST['puestoDescripcion'];
                $puestoNivel =  $_POST['puestoNivel'];
                $empleadoControl = $_POST['empleadoControl'];
                $puestoCorto = $_POST['puestoCorto'];
                $puestoCodigo = $_POST['puestoCodigo'];
                $hoy = date("Y-m-d H:m:s");

                $insert = "UPDATE tbpuesto SET 
                        [nombre] = ?
                        ,[descripcion] = ?
                        ,[nombre_corto] = ?
                        ,[id_nivel] = ?
                        ,[id_celula] = ?
                        ,[id_clasificacion] = ?
                        ,[updated_by] = ?
                        ,[updated_at] = ?
                        WHERE [codigo] = ?;";

                $params = array($puestoNombre,$puestoDescripcion,$puestoCorto,$puestoNivel,$puestoDepartamento,$puestoNivel,$empleadoControl,$hoy,$puestoCodigo);
            
                $stmt = sqlsrv_query( $con, $insert, $params);

                if( $stmt ) {
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => 'Actualizado',
                        'mensaje' => 'Informacion obtenida'                  
                    );
                } 
                else {
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'Error al actualizar',
                        'mensaje' => 'No hay datos en la BD'             
                    );
                }               

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
            break;
            case 'obtenerPuestos':
                // die(json_encode($_POST));
                $query = "SELECT * FROM tbpuesto ORDER BY updated_at DESC";
                
                $stmt = sqlsrv_query( $con, $query);

                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'datos-gafete':
                // die(json_encode($_POST));
                $nomina =  $_POST['nomina'];
                $query = "SELECT te.nombre_largo,fecha_alta,te.numero_nomina,te.nss,td.dv,td.contacto_emergencia_numero,td.codigo_postal,td.calle,td.numero_exterior,td.fraccionamiento,td.estado,td.municipio,td.domicilio_completo,tp.nombre puesto
                            FROM tbempleados AS te
                            INNER JOIN tbdatos_empleados AS td
                            ON te.numero_nomina = td.numero_nomina
                            INNER JOIN tbpuesto AS tp
                            ON te.id_puesto = tp.id_puesto
                            WHERE te.numero_nomina = ?";

                $params = array($nomina);
                
                $stmt = sqlsrv_query( $con, $query, $params);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'datos-formato':
                //die(json_encode($_POST));
                $nomina =  $_POST['nomina'];
                $query = "EXEC datos_empleado_formato @NUMERO_NOMINA = ?";

                $params = array($nomina);
                
                $stmt = sqlsrv_query( $con, $query, $params);
                
                $result = array();
                
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                    $respuesta = array(
                        'estado' => 'NOK',
                        'tipo' => 'error',
                        'informacion' => 'No existe informacion',
                        'mensaje' => 'No hay datos en la BD'                
                    );
                } else {
                    do {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                        $result[] = $row; 
                        }
                    } while (sqlsrv_next_result($stmt));
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'success',
                        'informacion' => $result,
                        'mensaje' => 'Informacion obtenida'                
                    );
                }

                echo json_encode($respuesta);
                sqlsrv_free_stmt( $stmt);
                sqlsrv_close( $con );
            break;
            case 'guardarFoto':
                // die(json_encode($_POST));
                $empNomina = $_POST['empNomina'];
                
                if(isset($_FILES["empFoto"]["name"])){
                    $respuesta = array(
                        'estado' => 'OK'
                    );
                    $directorio = 'imagenes/'.$empNomina;
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

            echo json_encode($respuesta);
            break;
            case 'revisarImagen':
                // die(json_encode($_POST));
                $ruta = 'imagenes/';
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
            default:
            echo 'NO DATA RETRIVE.';
            break;
        }

?>