
/**FUNCION QUITAR ESPACIOS EN BLANCO DE TEXTO**/
CREATE FUNCTION dbo.TRIM(@string VARCHAR(MAX))
RETURNS VARCHAR(MAX)
BEGIN
RETURN LTRIM(RTRIM(@string))
END
GO

/**CREAR TABLA EMPLEADOS**/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbempleados]( 
	[id_empleado] [int] IDENTITY(1,1) NOT NULL,
	[numero_nomina] [varchar](10) NOT NULL,
	[nombre_largo] [varchar](50) DEFAULT '',
	[nombre] [varchar](50) DEFAULT '',
	[apellido_paterno] [varchar](50) DEFAULT '',
	[apellido_materno] [varchar](50) DEFAULT '',
	[sexo] [varchar](1),
	[curpini] [varchar](5),
	[curpfin] [varchar](10),
	[rfcini] [varchar](5),
	[rfcfin] [varchar](10),
	[nss] [varchar](12),
	[fecha_nacimiento] [date],
	[fecha_alta] [date],
	[fecha_baja] [date],
	[status] [varchar] (1),
	[id_sucursal] [int] DEFAULT 0,
	[id_area] [int] DEFAULT 0,
	[id_celula] [int] DEFAULT 0,
	[id_puesto] [int] DEFAULT 0,
	[area_temp] [varchar](12) DEFAULT '',
	[departamento_temp] [varchar](10) DEFAULT '',
	[puesto_temp] [varchar](10) DEFAULT '',
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

/*CREAR TABLA SUCURSALES*/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbsucursal](
	[id_sucursal] [int] IDENTITY(1,1) NOT NULL,
	[codigo] [varchar](10) NOT NULL,
	[nombre] [varchar](50) DEFAULT '',
	[descripcion] [varchar](100) DEFAULT '',
	[nombre_corto] [varchar](10) DEFAULT '',
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO
select top 1 * from rh_empelados2

DROP TABLE tbdatos_empleados

/**CREAR TABLA DATOS EMPLEADOS*/
USE [MEXQAppTemp]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbdatos_empleados]( 
	[id_registro] [int] IDENTITY(1,1) NOT NULL,
	[numero_nomina] [varchar](10) NOT NULL,
	[clasificacion] [varchar](5) DEFAULT '',
	[categoria] [varchar](25) DEFAULT '',
	[nomina] [varchar](1) DEFAULT '',
	[registro_patronal] [varchar](10) DEFAULT 'SAC',
	[lote] [varchar](15) DEFAULT '',
	[dv] [varchar](3),
	[lugar_nacimiento] [varchar](45),
	[identificacion] [varchar](15),
	[numero_identificacion] [varchar](55),
	[estado_civil] [varchar](5),
	[escolaridad] [varchar](25),
	[constancia] [varchar](25),
	[nombre_padre] [varchar](65),
	[nombre_madre] [varchar](65),
	[calle] [varchar](65),
	[numero_interior] [varchar](10),
	[numero_exterior] [varchar](10),
	[fraccionamiento] [varchar](65),
	[domicilio_completo] [varchar](65),
	[codigo_postal] [varchar](5),
	[estado] [varchar](5),
	[municipio] [varchar](5),
	[localidad] [varchar](5),
	[infonavit] [varchar](2),
	[numero_infonavit] [varchar](35),
	[fonacot] [varchar](2),
	[numero_fonacot] [varchar](35),
	[cuenta] [varchar](2),
	[numero_cuenta] [varchar](35),
	[correo] [varchar](35) DEFAULT '',
	[telefono] [varchar](15) DEFAULT '',
	[celular] [varchar](15) DEFAULT '',
	[contacto_emergencia_nombre] [varchar](40) DEFAULT '',
	[contacto_emergencia_numero] [varchar](15) DEFAULT '',
	[posicion] [int],
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO



/*TRIGGER INSERTAR NUEVAS SUCURSALES / CELULAS*/
ALTER TRIGGER nuevaSucursal
ON PJPROJ
FOR INSERT
	AS DECLARE  @CODIGO_SUCURSAL VARCHAR(50),
				@SUCURSAL_PRINCIPAL VARCHAR(4),
				@NOMBRE_SUCURSAL VARCHAR(30),
				@DESC_SUCURSAL VARCHAR(50),
				@FECHA_SUCURSAL DATETIME,
				@ABR_SUCURSAL VARCHAR(5);
SELECT @CODIGO_SUCURSAL = ins.project FROM INSERTED ins;
SELECT @NOMBRE_SUCURSAL = ins.project_desc FROM INSERTED ins;
SELECT @SUCURSAL_PRINCIPAL = SUBSTRING(ins.project,6 , 4) FROM INSERTED ins;
SELECT @DESC_SUCURSAL = ins.project_desc FROM INSERTED ins;
SELECT @FECHA_SUCURSAL = ins.crtd_datetime FROM INSERTED ins;
SELECT @ABR_SUCURSAL = '100';
IF @SUCURSAL_PRINCIPAL = '0000'
	BEGIN
		INSERT INTO tbsucursal (codigo,nombre,descripcion,nombre_corto,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,@DESC_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
		INSERT INTO tbcelula (codigo,nombre,descripcion,codigo_area,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,'CELULA '+@NOMBRE_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
	END
ELSE IF @SUCURSAL_PRINCIPAL <> '0000'
	BEGIN
		INSERT INTO tbcelula (codigo,nombre,descripcion,codigo_area,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,@DESC_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
	END
GO

/**TRIGGER ACTUALIZA DATOS DEL EMPLEADO**/
DECLARE @CODIGO_SUCURSAL VARCHAR(10);
SELECT ins.nombrelargo FROM (SELECT * FROM [vEmpleadosNM] WHERE codigoempleado = '08444') ins;
SELECT * FROM [vEmpleadosNM]

/*CREAR TABLA AREAS*/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbarea](
	[id_area] [int] IDENTITY(1,1) NOT NULL,
	[codigo] [varchar](10) NOT NULL,
	[nombre] [varchar](50) DEFAULT '',
	[descripcion] [varchar](100) DEFAULT '',
	[nombre_corto] [varchar](20) DEFAULT '',
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

/*CREAR TABLA CELULAS*/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbcelula](
	[id_celula] [int] IDENTITY(1,1) NOT NULL,
	[codigo] [varchar](10) NOT NULL,
	[nombre] [varchar](50) DEFAULT '',
	[descripcion] [varchar](100) DEFAULT '',
	[nombre_corto] [varchar](20) DEFAULT '',
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

EXEC sp_rename 'tbcelula.nombre_corto', 'codigo_area', 'COLUMN';
select * from tbcelula

/**
DROP TABLE tbpuesto
**/
/*CREAR TABLA PUESTOS*/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbpuesto](
	[id_puesto] [int] IDENTITY(1,1) NOT NULL,
	[codigo] [varchar](10) NOT NULL,
	[nombre] [varchar](50) DEFAULT '',
	[descripcion] [varchar](100) DEFAULT '',
	[nombre_corto] [varchar](20) DEFAULT '',
	[id_nivel] [int] NOT NULL,
	[id_puestojefe] [int] NOT NULL,
	[id_celula] [int] NOT NULL,
	[id_clasificacion] [int] NOT NULL,
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

/*CREAR TABLA TIPO_PUESTOS*/
USE [MEXQAPPPR]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbtipopuesto](
	[id_puesto] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](50) DEFAULT '',
	[descripcion] [varchar](100) DEFAULT '',
	[nivel] [int] NOT NULL,
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

/*CREAR TABLA CORREOS*/
USE [MEXQApppr]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbcorreos](
	[id_correo] [int] IDENTITY(1,1) NOT NULL,
	[alias] [varchar](50) NOT NULL,
	[clave] [varchar](500) DEFAULT '',
	[lada] [varchar](5) DEFAULT '',
	[telefono] [varchar](10) DEFAULT '',
	[extension] [varchar](10) DEFAULT '',
	[celular] [varchar](15) DEFAULT '',
	[tipo] [int],
	[estado] BIT NULL DEFAULT 1,
	[numero_nomina] [varchar](10) NOT NULL,
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001'
) ON [PRIMARY]
GO

/*CREAR TABLA PERMISOS*/
USE [MEXQApppr]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbprivilegios_emp](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [varchar](25) NOT NULL,
	[descripcion] [varchar](75) NOT NULL,
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001',
	[panel_empleado] [int] DEFAULT 0,
	[panel_control] [int] DEFAULT 0,
	[panel_consultas] [int] DEFAULT 0,
	[panel_administraremp] [int] DEFAULT 0,
	[panel_administrar_usuarios] [int] DEFAULT 0
) ON [PRIMARY]
GO

ALTER TABLE tbprivilegios_emp
ADD [panel_dh] [int] DEFAULT 0;

INSERT INTO tbprivilegios_emp (tipo,descripcion,created_at) VALUES ('Laborales','Acceso a Laborales',GETDATE())
SELECT * FROM tbprivilegios_emp

/*CREAR TABLA RELACION EMPLEADOS-PERMISOS*/
USE [MEXQApppr]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbemp_permisos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numero_nomina] [varchar](10) NOT NULL,
	[created_at] [datetime],
	[created_by] [char](10) DEFAULT '00001',
	[updated_at] [datetime] default GETDATE(),
	[updated_by] [char](10) DEFAULT '00001',
	[emp_proy] [int],
) ON [PRIMARY]
GO

INSERT INTO tbemp_permisos (numero_nomina,created_at,emp_proy) VALUES ('26263',GETDATE(),1)

SELECT * FROM [dbo].[departamentos_nomipaq]
SELECT * FROM [dbo].[puestos_nomipaq] where idpuesto = '520'

/**SINONIMOS PARA TRABAJAR CON TABLAS **/
CREATE SYNONYM [dbo].[empleados_nomipaq]
FOR
[192.168.2.203\COMPAC].[ct2017_SERVICIOS_].[dbo].[nom10001]

CREATE SYNONYM [dbo].[departamentos_nomipaq]
FOR
[192.168.2.203\COMPAC].[ct2017_SERVICIOS_].[dbo].[nom10003]

CREATE SYNONYM [dbo].[puestos_nomipaq]
FOR
[192.168.2.203\COMPAC].[ct2017_SERVICIOS_].[dbo].[nom10006]

SELECT te.numero_nomina,te.nombre_largo,te.nombre,te.apellido_paterno,te.apellido_materno,te.status,te.fecha_alta,te.fecha_baja,te.fecha_nacimiento,
                        ts.nombre,ta.id_area,ta.codigo,ta.nombre,tc.id_celula,tc.codigo,tc.nombre,
                        pa.password
                        FROM tbempleados AS te 
                        INNER JOIN P1ACCESOWEB AS pa
                        ON te.numero_nomina = pa.employee
                        INNER JOIN tbsucursal AS ts
                        ON te.id_sucursal = ts.id_sucursal 
                        INNER JOIN tbcelula AS tc
                        ON tc.id_celula = te.id_celula
                        INNER JOIN tbarea AS ta
                        ON ta.codigo = tc.codigo_area
                        AND te.numero_nomina = '08444'

/**STORED FUINCTION LOGIN*/

ALTER PROCEDURE datos_empleado_acceso
@NUMERO_NOMINA VARCHAR(10)
AS
	BEGIN
	DECLARE @PERMISOS INT
		SET @PERMISOS = (SELECT emp_proy FROM tbemp_permisos WHERE numero_nomina= @NUMERO_NOMINA)
		SELECT te.numero_nomina,te.nombre_largo,te.nombre,te.apellido_paterno,te.apellido_materno,te.status,te.fecha_alta,te.fecha_baja,te.fecha_nacimiento,
		ts.nombre,ta.id_area,ta.codigo,ta.nombre,tc.id_celula,tc.codigo,tc.nombre,
		CASE WHEN @PERMISOS = 0 THEN '0' ELSE @PERMISOS END  AS nivel,
		pa.password
		FROM tbempleados AS te 
		INNER JOIN P1ACCESOWEB AS pa
		ON te.numero_nomina = pa.employee
		INNER JOIN tbsucursal AS ts
		ON te.id_sucursal = ts.id_sucursal 
		INNER JOIN tbcelula AS tc
		ON tc.id_celula = te.id_celula
		INNER JOIN tbarea AS ta
		ON ta.codigo = tc.codigo_area
		AND te.numero_nomina = @NUMERO_NOMINA
	END
GO

--ver 
select pa.*, PE.status from P1ACCESOWEB as pa
INNER JOIN tbempleados AS pe
on pa.employee = pe.numero_nomina
and pe.status = 'A'

SELECT * FROM tbemp_permisos WHERE numero_nomina='08444'
EXEC datos_empleado_acceso @NUMERO_NOMINA = '19905'

/**VISTA PUESTOS NOMPIAQ**/
ALTER VIEW PUESTOS_NOMINAS AS
SELECT CAST(idpuesto AS VARCHAR(10)) COLLATE SQL_Latin1_General_CP1_CI_AS AS idpuesto,
descripcion COLLATE SQL_Latin1_General_CP1_CI_AS AS descripcion
FROM [192.168.2.203\COMPAC].[ct2017_SERVICIOS_].[dbo].[nom10006]


/** VISTA EMPLEADOS NOMIPAQ */
ALTER VIEW [vEmpleadosNM] AS
SELECT 
codigoempleado,nombrelargo,nombre,apellidopaterno,apellidomaterno,sexo,fechaalta,fechabaja,REPLACE(campoextra2,'-','') AS Area,idpuesto,iddepartamento,
curpi,curpf,rfc, homoclave,numerosegurosocial,fechanacimiento,estadoempleado,
timestamp AS fechaCaptura
FROM 
[empleados_nomipaq]
UNION 
SELECT 
codigoempleado,nombrelargo,nombre,apellidopaterno,apellidomaterno,sexo,fechaalta,fechabaja,REPLACE(campoextra2,'-','') AS Area,idpuesto,iddepartamento,
curpi,curpf,rfc, homoclave,numerosegurosocial,fechanacimiento,estadoempleado,
timestamp AS fechaCaptura
FROM 
[192.168.2.203\COMPAC].[ct2017_CALIDAD_DE].[dbo].[nom10001]

/**VISTA DATOS DEL EMPLEADO**/
ALTER VIEW [vDatosEmpleados] AS
SELECT 
codigoempleado,telefono,codigopostal,direccion,poblacion,estado,nombrepadre,nombremadre,estadocivil,timestamp AS fechaCaptura,estadoempleado
FROM 
[empleados_nomipaq]
UNION 
SELECT 
codigoempleado,telefono,codigopostal,direccion,poblacion,estado,nombrepadre,nombremadre,estadocivil,timestamp AS fechaCaptura,estadoempleado
FROM 
[192.168.2.203\COMPAC].[ct2017_CALIDAD_DE].[dbo].[nom10001]


/**TABLAS NOMIPAQ**/
SELECT TOP 5 direccion, * FROM [vDatosEmpleados] WHERE direccion <> ''
SELECT TOP 5 substring(direccion,CHARINDEX('#',direccion)-1,250) AS CALLE, * FROM [vDatosEmpleados] WHERE direccion <> ''

SELECT * FROM [empleados_nomipaq]
SELECT * FROM [192.168.2.203\COMPAC].[ct2017_CALIDAD_DE].[dbo].[nom10001]

/** PROCEDIMIENTO PARA INSERTAR NUEVOS EMPLEADOS*/
--ANTIGUO
CREATE PROCEDURE pdemployeeInsert
AS 
	BEGIN
		INSERT INTO tbempleados (numero_nomina,nombre_largo,nombre,apellido_paterno,apellido_materno,sexo,fecha_alta,fecha_baja,area_temp,puesto_temp,departamento_temp,curpini,curpfin,rfcini,rfcfin,nss,fecha_nacimiento,status,created_at)
		SELECT *
		FROM [vEmpleadosNM]
		WHERE codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS NOT IN (SELECT numero_nomina FROM tbempleados)  ORDER BY fechaCaptura DESC;
	END
GO

/**PROCEDIMIENTO ACTUALIZAR STATUS DEL EMPLEADO*/
UPDATE empleados
SET 
status = tb2.estadoempleado,
fecha_baja = tb2.fechabaja,
updated_at = tb2.fechaCaptura,
updated_by = '00001'
FROM tbempleados AS empleados
INNER JOIN [vEmpleadosNM] AS tb2
ON empleados.numero_nomina COLLATE SQL_Latin1_General_CP1_CI_AS = tb2.codigoempleado

--VALIDAR SI HAY DIFERENCIAS ENTRE NOMIPAQ Y SISTEMA
SELECT * FROM [vEmpleadosNM]
WHERE codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS NOT IN (SELECT numero_nomina FROM tbempleados) ORDER BY fechaCaptura DESC;

SELECT COUNT(*) FROM tbempleados
SELECT COUNT(*) FROM [vEmpleadosNM]

SELECT COUNT(*) FROM tbempleados WHERE status = 'B'
SELECT COUNT(*) FROM [vEmpleadosNM] WHERE estadoempleado = 'B'


/**SINCRONIZAR EMPLEADOS*/
EXEC pdemployeeInsert

/**ACTUALIZAR TB EMPLEADOS DESDE PJEMPLOY**/
SELECT lupd_datetime AS ALTA, * FROM PJEMPLOY ORDER BY lupd_datetime
--DELETE FROM PJEMPLOY WHERE employee IN ('77771','7777E','77772','77777')
--TRUNCATE TABLE tbempleados2 
SELECT * FROM tbempleados2 ORDER BY created_at

ALTER TRIGGER _newEmployee ON PJEMPLOY
FOR INSERT
AS BEGIN
	SET NOCOUNT ON;
    DECLARE @numero_nomina VARCHAR(5),
			@nombre_largo VARCHAR(50),
			@fecha_alta DATETIME,
			@fecha_baja DATETIME,
			@empleado_status VARCHAR(1),
			@fecha_captura DATETIME,
			@campo_aux VARCHAR(25);

	SELECT @numero_nomina = ins.employee FROM INSERTED ins;
	SELECT @nombre_largo = dbo.TRIM(UPPER(ins.emp_name)) FROM INSERTED ins;
	SELECT @fecha_alta = ins.date_hired FROM INSERTED ins;
	SELECT @fecha_baja = ins.date_terminated FROM INSERTED ins;
	SELECT @empleado_status = ins.emp_status FROM INSERTED ins;
	SELECT @fecha_captura = ins.crtd_datetime FROM INSERTED ins;
	SELECT @campo_aux = ins.em_id03 FROM INSERTED ins;
IF ISNUMERIC(@numero_nomina) = 1 AND @campo_aux = ''
	BEGIN
		INSERT INTO tbempleados(numero_nomina,nombre_largo,fecha_alta,fecha_baja,status,created_at)
		VALUES (@numero_nomina,@nombre_largo,@fecha_alta,@fecha_baja,@empleado_status,@fecha_captura)
	END
ELSE
	BEGIN
		PRINT N'This user has SET NOCOUNT turned ON.';
	END
END
GO


ALTER TRIGGER _updateEmployee ON PJEMPLOY
FOR UPDATE
AS BEGIN
	SET NOCOUNT ON;
    DECLARE @numero_nomina VARCHAR(5),
			@nombre_largo VARCHAR(50),
			@fecha_baja DATETIME,
			@empleado_status VARCHAR(1),
			@fecha_captura DATETIME;

	SELECT @numero_nomina = upd.employee FROM INSERTED upd;
	SELECT @nombre_largo = dbo.TRIM(UPPER(upd.emp_name)) FROM INSERTED upd;
	SELECT @fecha_baja = upd.date_terminated FROM INSERTED upd;
	SELECT @empleado_status = upd.emp_status FROM INSERTED upd;
	SELECT @fecha_captura = upd.lupd_datetime FROM INSERTED upd;
	IF @empleado_status = 'I'
		BEGIN
			SET @empleado_status = 'B'
		END
	BEGIN
		UPDATE tbempleados SET nombre_largo = @nombre_largo, fecha_baja = @fecha_baja, status = @empleado_status, updated_at = @fecha_captura WHERE numero_nomina = @numero_nomina;
	END
END
GO

SELECT TOP 1 * FROM [vEmpleadosNM] where codigoempleado = '26354'
SELECT id_sucursal FROM tbsucursal WHERE SUBSTRING (codigo,1,5) = SUBSTRING ('CEAGS0583',1,5)
SELECT * FROM rh_empelados2 where no_trab = '24976'

--ACTUALIZAR DATOS DEL EMPLEADO DESDE NOMIPAQ
UPDATE empleados
SET 
nombre_largo = dbo.TRIM(UPPER(tb2.nombrelargo)),
nombre = dbo.TRIM(UPPER(tb2.nombre)),
apellido_paterno = dbo.TRIM(UPPER(tb2.apellidopaterno)),
apellido_materno = dbo.TRIM(UPPER(tb2.apellidomaterno)),
sexo = tb2.sexo,
curpini = tb2.curpi,
curpfin = tb2.curpf,
rfcini = tb2.rfc,
rfcfin = tb2.homoclave,
nss = tb2.numerosegurosocial,
fecha_nacimiento = tb2.fechanacimiento,
id_sucursal = (SELECT id_sucursal FROM tbsucursal WHERE SUBSTRING (codigo,1,5) COLLATE SQL_Latin1_General_CP1_CI_AS = SUBSTRING (tb2.Area,1,5)),
id_celula = (SELECT id_celula FROM tbcelula WHERE codigo COLLATE SQL_Latin1_General_CP1_CI_AS = tb2.Area),
area_temp = tb2.Area,
departamento_temp = tb2.iddepartamento,
puesto_temp = tb2.idpuesto,
updated_at = tb2.fechaCaptura,
updated_by = '00001'
FROM tbempleados AS empleados
INNER JOIN [vEmpleadosNM] AS tb2
ON empleados.numero_nomina COLLATE SQL_Latin1_General_CP1_CI_AS = tb2.codigoempleado
AND empleados.id_sucursal = 0 AND empleados.id_area = 0

/**BAJAS DESDE NOMIPAQ**/
UPDATE empleadosE
SET
fecha_baja = tbN.fechabaja
FROM tbempleados empleadosE
INNER JOIN [vEmpleadosNM] AS tbN
ON empleadosE.numero_nomina COLLATE SQL_Latin1_General_CP1_CI_AS = tbN.codigoempleado
AND empleadosE.fecha_baja = '01-01-1900' AND empleadosE.status = 'B'

SELECT * FROM tbempleados WHERE fecha_baja = '01-01-1900' AND status = 'B'


/**
DROP TABLE tbpuesto
TRUNCATE TABLE tbpuesto
**/
/**
1. LABORALES ALTA DE EMPLEADO 
2. PASA FORMATO A NOMINAS (CAPTURA EN ERP AL DIA, EN NOMIPAQ AL SIGUIENTE PERIODO) 
3. 

(PANEL, EMPLEADDOS, CAMBIOS DE PUESTOS, 
(EXPORTAR A EXCEL, ALTAS A NOMINAS)
erp como base numero nomina, nombre, fecha alta, estado.
tb 34 nomipaq
**/

/*CONSULTAS*/
SELECT * FROM PJEMPLOY WHERE employee = '08444'
SELECT TOP 1 * FROM [vEmpleadosNM] where codigoempleado = '08444' ORDER BY fechaCaptura DESC 
SELECT * FROM tbempleados where numero_nomina = '08444' ORDER BY updated_at DESC
UPDATE tbempleados SET status = 'B' where numero_nomina = '08444'
SELECT * FROM tbsucursal
SELECT * FROM tbarea
SELECT * FROM tbcelula
SELECT * FROM tbcorreos
SELECT * FROM tbpuesto
SELECT * FROM tbtipopuesto
SELECT * FROM tbprivilegios_emp
SELECT * FROM tbemp_permisos
SELECT * FROM tbdatos_empleados

SELECT te.numero_nomina, te.nombre_largo, 
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
WHERE te.numero_nomina = '19721'

SELECT te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta, 
ts.nombre,te.status,te.updated_at
FROM tbempleados AS te
INNER JOIN tbsucursal AS ts
ON te.id_sucursal = ts.id_sucursal WHERE te.status <> 'B' 
AND te.numero_nomina = '21629'
ORDER BY te.updated_at DESC, te.status ASC, te.fecha_alta DESC

SELECT te.id_empleado,te.numero_nomina,te.nombre_largo, CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja, 
                            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
                            FROM tbempleados AS te
                            INNER JOIN tbsucursal AS ts
                            ON te.id_sucursal = ts.id_sucursal 
							INNER JOIN tbcelula AS tc
							ON tc.id_celula = te.id_celula
							INNER JOIN tbarea AS ta
                            ON ta.codigo = tc.codigo_area
                            WHERE te.status = 'B' 
							AND (te.numero_nomina LIKE '%21629%')
                            ORDER BY te.status ASC, te.fecha_alta DESC
						

--9039	
SELECT * FROM [192.168.2.203\COMPAC].[ct2017_SERVICIOS_].[dbo].[nom10034]
--9021
SELECT * FROM [192.168.2.203\COMPAC].[ctM_2017_SERVICIO].[dbo].[nom10001]
--2127
SELECT * FROM [192.168.2.203\COMPAC].[ct2017_CALIDAD_DE].[dbo].[nom10001]
--2127
SELECT * FROM [192.168.2.203\COMPAC].[ctM_2017_CALIDAD_].[dbo].[nom10001]
--2
SELECT * FROM [192.168.2.203\COMPAC].[ctSERVICIOS_DE_AS].[dbo].[nom10001]

/**COMPLETAR REGISTROS*/

SELECT * FROM [departamentos_nomipaq]

SELECT te.numero_nomina,te.nombre_largo,te.fecha_alta,te.id_sucursal,vde.estado,vde.poblacion,vde.codigopostal,te.status,vde.*
FROM [vDatosEmpleados] AS vde
INNER JOIN	tbempleados AS te 
ON vde.codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS = te.numero_nomina
AND codigopostal <> ''
AND te.status <> 'B' 
ORDER BY te.fecha_alta

--COMPLETAR SUCURSAL (OMITIR LOS YA ASIGNADOS)
SELECT ts.id_sucursal,te.numero_nomina,te.nombre_largo,te.area_temp,te.id_celula FROM tbempleados AS te
INNER JOIN tbsucursal AS ts 
ON SUBSTRING(te.area_temp,1,5) = SUBSTRING(ts.codigo,1,5) AND te.id_celula = 0

--COMPLETAR SUCURSAL (OMITIR LOS YA ASIGNADOS)
SELECT tc.id_celula,tc.nombre,te.numero_nomina,te.nombre_largo,te.area_temp,te.id_celula FROM tbempleados AS te
INNER JOIN tbcelula AS tc 
ON te.area_temp = tc.codigo
AND te.id_celula <> 0

SELECT COUNT(*) AS cifras FROM tbempleados WHERE status <> 'B' UNION ALL
SELECT COUNT(*) AS totalEmpleadosAdministrativos FROM tbempleados WHERE area_temp LIKE '99COR%' AND status <> 'B' UNION ALL
SELECT COUNT(*) AS totalEmpleadosOperativos FROM tbempleados WHERE area_temp NOT LIKE '99COR%' AND status <> 'B' UNION ALL
SELECT COUNT(*) AS totalEmpleadosActuales FROM tbempleados WHERE YEAR(fecha_alta) >= YEAR(GETDATE()) AND status <> 'B' UNION ALL
select COUNT(*) AS totalSucursales from tbsucursal where codigo NOT IN ('000000000','99CON0000','99COR0000')


SELECT COUNT (*) AS contador,
			FORMAT(fecha_alta, 'MMMM', 'es-es') AS 'Mes',
             MONTH(fecha_alta) AS mes
    FROM tbempleados
   WHERE YEAR(fecha_alta)= YEAR(GETDATE())
GROUP BY MONTH(fecha_alta), FORMAT(fecha_alta, 'MMMM', 'es-es')
ORDER BY MONTH(fecha_alta) ASC;

SELECT SUBSTRING(area_temp,3,3) AS sucursal,
		COUNT (*) AS cantidad
    FROM tbempleados
   WHERE SUBSTRING(area_temp,3,3) <> '' AND status <> 'B'
GROUP BY SUBSTRING(area_temp,3,3)
ORDER BY SUBSTRING(area_temp,3,3) ASC;


SELECT 
SUM(CASE WHEN area_temp LIKE '99COR%' AND status <> 'B' THEN 1 ELSE 0 END) AS corporativo,
SUM(CASE WHEN area_temp NOT LIKE '99COR%' AND status <> 'B' THEN 1 ELSE 0 END) AS operativo
FROM tbempleados

SELECT 
SUM(CASE WHEN YEAR(fecha_alta)= YEAR(GETDATE()) AND status <> 'B' THEN 1 ELSE 0 END) AS altas,
SUM(CASE WHEN YEAR(fecha_baja)= YEAR(GETDATE()) AND status = 'B' THEN 1 ELSE 0 END) AS bajas
FROM tbempleados

SELECT COUNT (*) AS contador,
			SUM(CASE WHEN YEAR(fecha_alta)= YEAR(GETDATE()) AND status <> 'B' THEN 1 ELSE 0 END),
             SUM(CASE WHEN YEAR(fecha_baja)= YEAR(GETDATE()) AND status = 'B' THEN 1 ELSE 0 END)
    FROM tbempleados
GROUP BY MONTH(fecha_alta), FORMAT(fecha_alta, 'MMMM', 'es-es')
ORDER BY MONTH(fecha_alta) ASC;

select * from tbsucursal

SELECT tc.codigo,tc.nombre FROM tbcelula AS tc
INNER JOIN tbsucursal AS ts
ON SUBSTRING(tc.codigo,1,5) = SUBSTRING(ts.codigo,1,5)
WHERE SUBSTRING(tc.codigo,1,5) = '99COR'

SELECT tc.codigo,tc.nombre FROM tbcelula AS tc
INNER JOIN tbsucursal AS ts
ON SUBSTRING(tc.codigo,1,5) = SUBSTRING(ts.codigo,1,5)
WHERE SUBSTRING(tc.codigo,1,5) = SUBSTRING((SELECT codigo FROM tbsucursal WHERE id_sucursal = 3),1,5)
ORDER BY tc.nombre


select top 1 b.nombre,puesto,convert(varchar,fecha_alta),telefono_emergencia as a , no_trab,no_imss,cp,calle,numero, fraccionamiento,estado,municipio,a.dv  from (select * from rh_empelados2 ) as a  inner join 
(select emp_name as nombre,* from pjemploy ) as b on a.no_trab = b.employee
where employee='26389' order by fecha_alta desc

SELECT TOP 10 * FROM tbempleados 

/**CUMPLEAŅEROS***/
SELECT te.numero_nomina, te.nombre_largo, 
        CASE 
			WHEN tp.nombre IS NULL 
			THEN 
				b.descripcion
			ELSE tp.nombre 
		END AS 'Puesto',
        ts.nombre AS 'Sucursal',
		ta.nombre AS 'Departamento', 
		tc.nombre AS 'Celula',
		CONVERT(VARCHAR(10), te.fecha_nacimiento, 105) AS fechaNacimiento,
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
		INNER JOIN PUESTOS_NOMINAS b
		ON te.puesto_temp = b.idpuesto
        INNER JOIN tbsucursal AS ts
        ON te.id_sucursal = ts.id_sucursal
        INNER JOIN tbcelula AS tc
        ON tc.id_celula = te.id_celula
        INNER JOIN tbarea AS ta
        ON tc.codigo_area = ta.codigo
        LEFT JOIN tbpuesto AS tp
        ON te.id_puesto = tp.id_puesto
		WHERE MONTH(fecha_nacimiento) = MONTH(GETDATE()) AND DAY(fecha_nacimiento) >= DAY(GETDATE())
		ORDER BY MONTH(fecha_nacimiento),DAY(fecha_nacimiento) ASC


/**ANTIGUEDAD**/
SELECT te.numero_nomina, te.nombre_largo, 
        CASE 
			WHEN tp.nombre IS NULL 
			THEN 
				b.descripcion
			ELSE tp.nombre 
		END AS 'Puesto',
        ts.nombre AS 'Sucursal',
		ta.nombre AS 'Departamento', 
		tc.nombre AS 'Celula',
		CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
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
		INNER JOIN PUESTOS_NOMINAS b
		ON te.puesto_temp = b.idpuesto
        INNER JOIN tbsucursal AS ts
        ON te.id_sucursal = ts.id_sucursal
        INNER JOIN tbcelula AS tc
        ON tc.id_celula = te.id_celula
        INNER JOIN tbarea AS ta
        ON tc.codigo_area = ta.codigo
        LEFT JOIN tbpuesto AS tp
        ON te.id_puesto = tp.id_puesto
		WHERE 
		MONTH(fecha_alta) >= MONTH(GETDATE()) AND DAY(fecha_alta) >= DAY(GETDATE()) 
		AND te.status <> 'B'
		ORDER BY MONTH(fecha_alta),DAY(fecha_alta) ASC

/**LISTA DE EMPLEADOS**/
SELECT TOP 500 te.numero_nomina,UPPER(te.nombre_largo) AS Nombre, 
			CASE 
			WHEN tp.nombre IS NULL 
			THEN 
				b.descripcion
			ELSE tp.nombre
			END AS 'Puesto',
			CONVERT(VARCHAR(10), te.fecha_alta, 105) AS fechaAlta,
            ts.nombre AS 'Sucursal',ta.nombre AS 'Departamento',tc.nombre as 'Celula',te.status,te.created_at
            FROM tbempleados AS te
			INNER JOIN PUESTOS_NOMINAS b
			ON te.puesto_temp = b.idpuesto
            INNER JOIN tbsucursal AS ts
            ON te.id_sucursal = ts.id_sucursal 
            INNER JOIN tbcelula AS tc
            ON tc.id_celula = te.id_celula
            INNER JOIN tbarea AS ta
            ON ta.codigo = tc.codigo_area
			LEFT JOIN tbpuesto AS tp
			ON te.id_puesto = tp.id_puesto
            WHERE te.status <> 'B' 
            ORDER BY te.status ASC, te.created_at DESC

SELECT * FROM tbempleados where numero_nomina = '26539'

SELECT * FROM PUESTOS_NOMINAS where idpuesto = '227'

SELECT * FROM [vEmpleadosNM] WHERE codigoempleado = '26539'

SELECT * FROM tbpuesto

update tbpuesto set id_celula = 361 where id_puesto = 7 
update tbpuesto set id_celula = 360 where id_puesto = 42

SELECT tp.id_nivel,tp.id_puesto,tp.nombre,UPPER(te.nombre_largo) as nombre_largo,te.numero_nomina FROM 
tbpuesto AS tp
INNER JOIN tbempleados AS te
ON tp.id_puesto = te.id_puesto
INNER JOIN tbcelula AS tc
ON te.id_celula = tc.id_celula
INNER JOIN tbarea AS ta
ON tc.codigo_area = ta.codigo
AND tp.id_nivel < (SELECT id_nivel FROM tbpuesto WHERE id_puesto = 17)
AND (tp.id_celula = (SELECT id_celula FROM tbpuesto WHERE id_puesto = 17)) 
AND te.status <> 'B'
UNION ALL
SELECT tp.id_nivel,tp.id_puesto,tp.nombre,UPPER(te.nombre_largo) as nombre_largo,te.numero_nomina FROM tbpuesto AS tp
INNER JOIN tbempleados AS te
ON tp.id_puesto = te.id_puesto
INNER JOIN (SELECT id_celula FROM tbcelula WHERE codigo_area =
(SELECT area_superior FROM tbarea WHERE codigo = (SELECT codigo_area FROM tbcelula WHERE id_celula = 15)))
AS temp
ON temp.id_celula = tp.id_celula
ORDER BY id_nivel



SELECT * FROM tbarea
EXEC sp_RENAME 'tbarea.nombre_corto', 'area_superior', 'COLUMN'
UPDATE tbarea SET area_superior = ''
INSERT INTO tbarea (codigo,nombre,descripcion,area_superior,created_at) VALUES ('122','Subdireccion Operativa','Area Subdireccion Operativa','102',getdate())
INSERT INTO tbarea (codigo,nombre,descripcion,area_superior,created_at) VALUES ('123','Subdireccion Comercial','Area Subdireccion Comercial','102',getdate())
UPDATE tbarea SET area_superior = '123' where id_area = 1
UPDATE tbarea SET area_superior = '122' where id_area = 2
UPDATE tbarea SET area_superior = '122' where id_area = 3
UPDATE tbarea SET area_superior = '102' where id_area = 4
UPDATE tbarea SET area_superior = '102' where id_area = 5
UPDATE tbarea SET area_superior = '102' where id_area = 6
UPDATE tbarea SET area_superior = '103' where id_area = 7
UPDATE tbarea SET area_superior = '123' where id_area = 8
UPDATE tbarea SET area_superior = '123' where id_area = 9
UPDATE tbarea SET area_superior = '102' where id_area = 10
UPDATE tbarea SET area_superior = '122' where id_area = 11
UPDATE tbarea SET area_superior = '123' where id_area = 12
UPDATE tbarea SET area_superior = '121' where id_area = 13

select * from tbcelula
select * from tbcelula where codigo LIKE '99COR%'
INSERT INTO tbcelula (codigo,nombre,descripcion,codigo_area,created_at) VALUES ('99CORD017','Subdireccion Operativa','Area Subdireccion Operativa','122',getdate())
INSERT INTO tbcelula (codigo,nombre,descripcion,codigo_area,created_at) VALUES ('99CORD018','Subdireccion Comercial','Area Subdireccion Comercial','123',getdate())
UPDATE tbcelula SET codigo = '99CORD016' WHERE id_celula = 2

SELECT * FROM tbempleados WHERE numero_nomina = '01885'
UPDATE tbempleados SET id_celula = 361 WHERE numero_nomina = '01885'

SELECT id_puesto,nombre FROM tbpuesto WHERE id_celula = 28 ORDER BY id_nivel ASC

SELECT CONCAT(curpini + RIGHT(YEAR(fecha_nacimiento),2) , FORMAT(fecha_nacimiento,'MM') , CONVERT(CHAR(2),fecha_nacimiento,103) , curpfin), * FROM tbempleados
WHERE CONCAT(curpini + RIGHT(YEAR(fecha_nacimiento),2) , FORMAT(fecha_nacimiento,'MM') , CONVERT(CHAR(2),fecha_nacimiento,103) , curpfin) = 'VAFC920220HASLNS06'
SELECT top 1  CONCAT(curpini + RIGHT(YEAR(fecha_nacimiento),2) , FORMAT(fecha_nacimiento,'MM') , CONVERT(CHAR(2),fecha_nacimiento,103) , curpfin) AS curp, * FROM tbempleados where numero_nomina = '08444'

SELECT MAX(CAST(REPLACE(no_trab, ' ', '') AS INT)) as NUMERO FROM rh_empelados2 WHERE no_trab <> '----------' AND no_trab NOT LIKE '´%' AND DATALENGTH(CAST(REPLACE(no_trab, ' ', '') AS INT)) < 6
SELECT no_trab,* FROM rh_empelados2 WHERE no_trab = '----------'                                             
SELECT TOP 100 no_trab n,* FROM rh_empelados2 WHERE fecha_alta > '2019-06-01' order by no_trab DESC

/*OBTENER ULTIMO NUMERO DE NOMINA EN PJEMPLOYEE**/
SELECT top 1 MAX(CAST(REPLACE(employee, ' ', '') AS INT)) AS numeroNomina FROM PJEMPLOY WHERE ISNUMERIC(employee) = 1 AND em_id03 = '' GROUP BY crtd_datetime ORDER BY crtd_datetime DESC
SELECT MAX(CAST(numero_nomina AS INT)) AS numeroNomina FROM tbempleados

/**
16775
**/
select TOP 10 no_trab AS A, * from rh_empelados2 WHERE interior <> '' ORDER BY fecha_alta DESC
select * from [vDatosEmpleados] WHERE codigoempleado = '16775'
select * from tbdatos_empleados
select * from [vDatosEmpleados] where codigopostal <> 0

select REPLACE(no_trab,' ','') as NOMINA,REPLACE(categoria,'$','') AS categoria,SUBSTRING(nomina,1,1) AS nomina,SUBSTRING(clasificacion,1,1) AS clasificacion,registro,lote,dv,lugar_nacimiento,'ID',ide_oficial,
SUBSTRING(estado_civil,1,1) AS estado_civil,escolaridad,'constancia_escolar',
CONCAT(REPLACE(ape_pat_padre,' ',''),' ',REPLACE(ape_mat_padre,' ',''),' ',REPLACE(nombres_padre,' ','')) AS nombre_padre,
CONCAT(REPLACE(ape_pat_madre,' ',''),' ',REPLACE(ape_mat_madre,' ',''),' ',REPLACE(nombres_madre,' ','')) AS nombre_madre,
calle,numero,interior,fraccionamiento,'domicilio',cp,estado,municipio,localidad,
infonavit,no_infonavit,fonacot,no_fonacot,tarjeta_nomina,cuenta,
correo_electronico,telefono_casa,celular,telefono_emergencia,'','',GETDATE()
from rh_empelados2       
