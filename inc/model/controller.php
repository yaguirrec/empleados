<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS");
    
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }

        include 'connection_.php';   
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
                        $usuario_nombre = trim(ucwords(strtolower($row['nombre_largo'])));
                        $sesion = true;

                        $ubicacion = ((empty($usuario_nivel) || $usuario_nivel < 2) ? 'datos' : 'main');
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
        case 'mostrar-empleado':
            // die(json_encode($_POST));
            $props = $_POST['prop'];
            $query = "SELECT te.numero_nomina, te.nombre_largo, 
                        CASE WHEN tp.nombre IS NULL THEN 'Sin asignar' ELSE tp.nombre END AS 'Puesto',
                        ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento', tc.nombre AS 'Celula'
                        FROM tbempleados AS te
                        INNER JOIN tbsucursal AS ts
                        ON te.id_sucursal = ts.id_sucursal
                        INNER JOIN tbcelula AS tc
                        ON tc.id_celula = te.id_celula
                        INNER JOIN tbarea AS ta
                        ON tc.codigo_area = ta.codigo
                        LEFT JOIN tbpuesto AS tp
                        ON te.id_puesto = tp.id_puesto
                        WHERE te.numero_nomina = ?";

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
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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
                            WHERE te.status <> 'B' 
                            ORDER BY te.status ASC, te.created_at DESC";
            } 
            else if ($props == 'bajas')
            {
                $query = "SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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

        case 'json-empleados':
            $props = $_POST['prop'];
            if ($props == 'activos')
            {
                $query = "SELECT te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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
                            WHERE te.status <> 'B' 
                            ORDER BY te.status ASC, te.created_at DESC";
            } 
            else if ($props == 'bajas')
            {
                $query = "SELECT te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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
            $props = $_POST['prop'];
            $query = "SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS nombre_largo, 
                        CASE
                            WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                            THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                            ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
                        END AS puesto,
                        CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
                        ts.nombre AS 'sucursal',ta.nombre AS 'Departamento',tc.nombre as 'planta',te.status,te.created_at
                        FROM tbempleados AS te
                        INNER JOIN tbsucursal AS ts
                        ON te.id_sucursal = ts.id_sucursal 
                        INNER JOIN tbcelula AS tc
                        ON tc.id_celula = te.id_celula
                        INNER JOIN tbarea AS ta
                        ON ta.codigo = tc.codigo_area
                        AND te.status <> 'B' AND te.fecha_alta = ?
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
        case 'buscar-texto':
            // die(json_encode($_POST));
            $txtBuscado = $_POST['txtBuscado'];
            $props = $_POST['prop'];

            if ($props == 'activos')
            {
                $query = "SELECT te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
                            CASE
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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
                                WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
                                THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
                                ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
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
                $query = "SELECT TOP 250 te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,vde.estado,vde.poblacion,vde.codigopostal,vde.direccion,te.status
                FROM [vDatosEmpleados] AS vde
                INNER JOIN	tbempleados AS te 
                ON vde.codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS = te.numero_nomina
                AND codigopostal <> ''
                AND te.status <> 'B'
                ORDER BY te.fecha_alta DESC";
                
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
                                ON SUBSTRING(tc.codigo,1,5) = SUBSTRING(ts.codigo,1,5)
                                WHERE SUBSTRING(tc.codigo,1,5) <> '99COR'";
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
                }else{
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
            case 'validaCURP':
                // die(json_encode($_POST));
                $curp =  $_POST['curp'];
                $query = "SELECT numero_nomina FROM tbempleados
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
                // die(json_encode($_POST));
                    $nomina =  $_POST['nomina'];
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

                    $clasificacion =  $_POST['clasificacion'];
                    $categoria =  $_POST['categoria'];
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


                    $fechaControl =  date('Y-m-d H:i:s');
                    $userControl =  'testUser';
                    
                    $insert = "EXEC insertEmployeeData @nnomina = ?, 
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
                                                        @categoria  = ?,
                                                        @nomina  = ?,
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
                                                        @posicion = ?";


                    $params = array($nomina,$nombreLargo,$nombre,$aPaterno,$aMaterno,$genero,$curpini,$curpfin,$rfcini,$rfcfin,$nss,$fechaNacimiento,$fechaAlta,$fechaBaja,$status,$sucursal,$area,$celula,$puesto,
                                    $clasificacion,$categoria,$tipoNomina,$registro,$lote,$dv,$lNacimiento,$tIdentificacion,$id,$eCivil,$escolaridad,$cEscolaridad,$nPadre,$nMadre,$calle,$numE,$numI,$fraccionamiento,
                                    $domicilio,$cp,$edo,$municipio,$localidad,$infonavit,$nInfonavit,$fonacot,$nFonacot,$banco,$cuenta,$correo,$telefono,$celular,$contacto,$nContacto,$posicion);
                    
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
            case 'obtenerPuestos':
                // die(json_encode($_POST));
                $query = "SELECT * FROM tbpuesto";
                
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
                $query = "SELECT top 1 b.nombre,puesto,convert(varchar,fecha_alta) AS empAlta,telefono_emergencia as a , no_trab,no_imss,cp,calle,numero, fraccionamiento,estado,municipio,a.dv  from rh_empelados2  as a  inner join 
                            (select emp_name as nombre,* from pjemploy ) as b on a.no_trab = b.employee
                            where employee = ? order by fecha_alta desc";

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