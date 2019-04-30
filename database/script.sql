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
SELECT @NOMBRE_SUCURSAL = SUBSTRING(ins.project_desc,10 , 30) FROM INSERTED ins;
SELECT @SUCURSAL_PRINCIPAL = SUBSTRING(ins.project,6 , 4) FROM INSERTED ins;
SELECT @DESC_SUCURSAL = ins.project_desc FROM INSERTED ins;
SELECT @FECHA_SUCURSAL = ins.crtd_datetime FROM INSERTED ins;
SELECT @ABR_SUCURSAL = SUBSTRING(ins.project, 6, 4) FROM INSERTED ins;
IF @SUCURSAL_PRINCIPAL = '0000'
	BEGIN
		INSERT INTO tbsucursal (codigo,nombre,descripcion,nombre_corto,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,@DESC_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
		INSERT INTO tbcelula (codigo,nombre,descripcion,nombre_corto,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,'CELULA '+@NOMBRE_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
	END
ELSE IF @SUCURSAL_PRINCIPAL <> '0000'
	BEGIN
		INSERT INTO tbcelula (codigo,nombre,descripcion,nombre_corto,created_at) VALUES (@CODIGO_SUCURSAL,@NOMBRE_SUCURSAL,@DESC_SUCURSAL,@ABR_SUCURSAL,@FECHA_SUCURSAL);
	END
GO

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

/** PROCEDIMIENTO PARA INSERTAR NUEVOS EMPLEADOS*/
CREATE PROCEDURE pdemployeeInsert
AS 
	BEGIN
		INSERT INTO tbempleados (numero_nomina,nombre_largo,nombre,apellido_paterno,apellido_materno,sexo,fecha_alta,fecha_baja,area_temp,puesto_temp,departamento_temp,curpini,curpfin,rfcini,rfcfin,nss,fecha_nacimiento,status,created_at)
		SELECT *
		FROM [vEmpleadosNM]
		WHERE codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS NOT IN (SELECT numero_nomina FROM tbempleados)  ORDER BY fechaCaptura DESC;
	END 
GO

--VALIDAR SI HAY DIFERENCIAS ENTRE NOMIPAQ Y SISTEMA
SELECT * FROM [vEmpleadosNM]
WHERE codigoempleado COLLATE SQL_Latin1_General_CP1_CI_AS NOT IN (SELECT numero_nomina FROM tbempleados) ORDER BY fechaCaptura DESC;

SELECT COUNT(*) FROM tbempleados
SELECT COUNT(*) FROM [vEmpleadosNM]


/**SINCRONIZAR EMPLEADOS*/
EXEC pdemployeeInsert

/*CONSULTAS*/
SELECT * FROM tbempleados
SELECT * FROM tbsucursal
SELECT * FROM tbarea
SELECT * FROM tbcelula
SELECT * FROM tbcorreos
SELECT * FROM tbpuesto
