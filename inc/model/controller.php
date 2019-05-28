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
        // $conn -> query("SET NAMES utf8");
        $action  = $_POST['action'];
        
        if($action == 'login')
        {
            // die(json_encode($_POST));
            $user = $_POST['usuario'];
            $password = $_POST['clave'];
            $password = hash('sha512', $password);

            $query = "SELECT pe.numero_nomina, ui.badgenumber Bnomina,pe.nombre_largo, ui.name,ui.lastname,dp.code depto_id,dp.deptname,aw.password
                        FROM 
                        tbempleados as pe
                        RIGHT JOIN P1ACCESOWEB aw
                        ON pe.numero_nomina = aw.employee
                        INNER JOIN userinfo ui
                        ON RIGHT(ui.badgenumber, 5) = aw.employee
                        INNER JOIN departments dp
                        ON ui.defaultdeptid = dp.deptid
                        WHERE pe.numero_nomina = ?"; 

            

            $params = array($user);//Pasar parametros a las consulta ?

            $stmt = sqlsrv_query( $con, $query, $params );// Asignar parametros al Statement a ejecutar

            // die(json_encode($params));


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
                // die(json_encode($_POST));
                $clave_bd = trim($row['password']);
                if( strcasecmp($clave_bd, $password) == 0 )
                {
                    $usuario_activo = trim($row['numero_nomina']);
                    $usuario_departamento = trim($row['depto_id']);
                    $usuario_nombre = trim(ucwords(strtolower($row['nombre_largo'])));
                    $sesion = true;
                    // session_start();//INICIAR LA SESION
                    $respuesta = array(
                        'estado' => 'OK',
                        'ubicacion' => 'main',
                        'tipo' => 'success',
                        'mensaje' => 'Ingreso exitoso!',
                        'informacion' => 'Bienvenido',
                        'usuario_activo' => $usuario_activo,
                        'usuario_departamento' => $usuario_departamento,
                        'usuario_nombre'    => $usuario_nombre,
                        'sesion' => $sesion
                    );
                }else{
                    $sesion = false;
                    $respuesta = array(
                        'estado' => 'OK',
                        'tipo' => 'error',
                        'mensaje' => 'Usuario y clave incorrectos.',
                        'informacion' => 'Las credenciales ingresadas no son válidas.',
                        'sesion' => $sesion
                    );
                }
            }
            //El usuario no existe
            else 
            {
                $sesion = true;
                $respuesta = array(
                    'estado' => 'OK',
                    'tipo' => 'error',
                    'informacion' => 'No existe usuario',
                    'mensaje' => 'Usuario y/o clave incorrectos.',
                    'sesion' => $sesion
                    
                );
            }
            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        }
        else if ($action == 'lista-empleados')
        {
            // die(json_encode($_POST));
            $props = $_POST['prop'];
            if ($props == 'activos')
            {
                $query = "SELECT TOP 100 te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            WHERE te.status <> 'B' 
                            ORDER BY te.status ASC, te.fecha_alta DESC";
            } 
            else 
            {
                $query = "SELECT TOP 100 te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
                            INNER JOIN tbcelula AS tc
                            ON tc.id_celula = te.id_celula
                            INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            WHERE te.status = 'B' 
                            ORDER BY te.status ASC, te.fecha_alta DESC";
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
        }
        else if ($action == 'mostrar-empleado')
        {
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
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        }
        else if ($action == 'buscar-texto')
        {
            // die(json_encode($_POST));
            $txtBuscado = $_POST['txtBuscado'];
            $props = $_POST['prop'];

            if ($props == 'activos')
            {
                $query = "SELECT TOP 250 te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
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
                            
                            $query .= "ORDER BY te.status ASC, te.fecha_alta DESC";
            } 
            else 
            {
                $query = "SELECT TOP 250 te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
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
                    'mensaje' => 'Informacion obtenida'                
                );
            }

            echo json_encode($respuesta);
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $con );
        }

?>