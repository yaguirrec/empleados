SELECT * FROM tbdatos_empleados WHERE numero_nomina = '26841'

EXEC datos_empleado_consulta '26841'
EXEC datos_empleado_formato '26757'
EXEC consulta_datos_empleado '26757'

/**AGREGAR COLUMAND E TABULADRO A TABLA DE DATOS EMPLEADOS**/
ALTER TABLE tbdatos_empleados
ADD tabulador varchar(10);

/**ACTUALIZAR SP INSERTAR NUEVO EMPLEADO**/
USE [MEXQApppr]
GO
/****** Object:  StoredProcedure [dbo].[insertEmployeeData]    Script Date: 08/11/2019 03:13:28 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[insertEmployeeData](
								@nnomina varchar(10), 
								@jnomina varchar(5),
								@codigo_tabulador varchar(10),
								@nlargo varchar(85), 
								@nombre varchar(35), 
								@apaterno varchar(35),
								@amaterno varchar(35),
								@sexo varchar(5),
								@curpi varchar(25),
								@curpf varchar(25),
								@rfcini varchar(25),
								@rfcfin varchar(25),
								@nss varchar(25),
								@fechan DATE,
								@fechaa DATE,
								@fechab DATE,
								@status varchar(2),
								@comentario text,
								@ids INT,
								@ida INT,
								@idc INT,
								@idp INT,
								@clasificacion varchar(8)
							   ,@salarioDiario varchar(25)
							   ,@salarioMensual varchar(25)
							   ,@nomina  varchar(1)
							   ,@registro_patronal  varchar(10)
							   ,@lote  varchar(15)
							   ,@dv  varchar(3)
							   ,@lugar_nacimiento  varchar(45)
							   ,@identificacion  varchar(15)
							   ,@numero_identificacion  varchar(65)
							   ,@estado_civil  varchar(5)
							   ,@escolaridad  varchar(25)
							   ,@constancia  varchar(25)
							   ,@nombre_padre  varchar(65)
							   ,@nombre_madre  varchar(65)
							   ,@calle  varchar(65)
							   ,@numero_interior  varchar(10)
							   ,@numero_exterior  varchar(10)
							   ,@fraccionamiento  varchar(65)
							   ,@domicilio_completo  varchar(65)
							   ,@codigo_postal  varchar(5)
							   ,@estado  varchar(55)
							   ,@municipio  varchar(55)
							   ,@localidad  varchar(55)
							   ,@infonavit  varchar(2)
							   ,@numero_infonavit  varchar(35)
							   ,@fonacot  varchar(2)
							   ,@numero_fonacot  varchar(35)
							   ,@cuenta  varchar(2)
							   ,@numero_cuenta  varchar(35)
							   ,@correo  varchar(55)
							   ,@telefono  varchar(25)
							   ,@celular  varchar(25)
							   ,@contacto_emergencia_nombre  varchar(40)
							   ,@contacto_emergencia_numero  varchar(15)
							   ,@posicion int
							   ,@nominaControl varchar(5)
							   )

AS
BEGIN TRY
     BEGIN TRANSACTION
		/*ALTA EN TABLA TBEMPLEADOS PARA MANEJO DE PERFILES*/
           INSERT INTO [tbempleados]
                            ([numero_nomina]
                            ,[nombre_largo]
                            ,[nombre]
                            ,[apellido_paterno]
                            ,[apellido_materno]
                            ,[sexo]
                            ,[curpini]
                            ,[curpfin]
                            ,[rfcini]
                            ,[rfcfin]
                            ,[nss]
                            ,[fecha_nacimiento]
                            ,[fecha_alta]
                            ,[fecha_baja]
                            ,[status]
                            ,[id_sucursal]
                            ,[id_area]
                            ,[id_celula]
                            ,[id_puesto]
                            ,[created_at]
							,[created_by])
                            VALUES
                            (@nnomina,UPPER(@nlargo),UPPER(@nombre),UPPER(@apaterno),UPPER(@amaterno),UPPER(@sexo),UPPER(@curpi),UPPER(@curpf),UPPER(@rfcini),UPPER(@rfcfin),@nss,@fechan,@fechaa,@fechab,@status,@ids,@ida,@idc,@idp,GETDATE(),@nominaControl);
           /*ALTA EN TABLA TBDATOS_EMPLEADOS PARA CONTROL DE INFORMACION DEL EMPLEADO*/
		   INSERT INTO [tbdatos_empleados]
										(	[numero_nomina],
											[clasificacion],
											[salario_diario],
											[salario_mensual],
											[nomina],
											[registro_patronal],
											[lote],
											[dv],
											[lugar_nacimiento],
											[identificacion],
											[numero_identificacion],
											[estado_civil],
											[escolaridad],
											[constancia],
											[nombre_padre],
											[nombre_madre],
											[calle],
											[numero_exterior],
											[numero_interior],
											[fraccionamiento],
											[domicilio_completo],
											[codigo_postal],
											[estado],
											[municipio],
											[localidad],
											[infonavit],
											[numero_infonavit],
											[fonacot],
											[numero_fonacot],
											[cuenta],
											[numero_cuenta],
											[correo],
											[telefono],
											[celular],
											[contacto_emergencia_nombre],
											[contacto_emergencia_numero],
											[posicion],
											[comentarios],
											[tabulador],
											[created_at],
											[created_by]
										)
										VALUES
										(@nnomina,@clasificacion,@salarioDiario,@salarioMensual,@nomina,@registro_patronal,@lote,@dv,UPPER(@lugar_nacimiento),@identificacion,@numero_identificacion,@estado_civil,@escolaridad,@constancia,
										UPPER(@nombre_padre),UPPER(@nombre_madre),UPPER(@calle),@numero_exterior,@numero_interior,@fraccionamiento,UPPER(@domicilio_completo),@codigo_postal,@estado,@municipio,@localidad,@infonavit,@numero_infonavit,
										@fonacot,@numero_fonacot,@cuenta,@numero_cuenta,UPPER(@correo),@telefono,@celular,UPPER(@contacto_emergencia_nombre),@contacto_emergencia_numero,@posicion,@comentario,@codigo_tabulador,GETDATE(),@nominaControl);
										/*ALTA EN TABLA PJEMPLOY PARA CONTROL EN ERP*/
										INSERT INTO [PJEMPLOY] ([BaseCuryId], [CpnyId], [crtd_datetime], [crtd_prog], [crtd_user], [CuryId], [CuryRateType], [date_hired], [date_terminated], [employee], [emp_name], [emp_status], [emp_type_cd], [em_id01], [em_id02], [em_id03], [em_id04], [em_id05], [em_id06], [em_id07], [em_id08], [em_id09], [em_id10], [em_id11], [em_id12], [em_id13], [em_id14], [em_id15], [em_id16], [em_id17], [em_id18], [em_id19], [em_id20], [em_id21], [em_id22], [em_id23], [em_id24], [em_id25], [exp_approval_max], [gl_subacct], [lupd_datetime], [lupd_prog], [lupd_user], [manager1], [manager2], [MSPData], [MSPInterface], [MSPRes_UID], [MSPType], [noteid], [placeholder], [stdday], [Stdweek], [Subcontractor], [user1], [user2], [user3], [user4], [user_id])
										VALUES
										(N'    ', N'0010      ', CAST(GETDATE() AS SmallDateTime), N'PAEMP   ', N'WEBSYS', N'    ', N'      ', CAST(@fechaa AS SmallDateTime), CAST(N'1900-01-01T00:00:00' AS SmallDateTime), @nnomina, UPPER(@nlargo), N'A', N'', N'                              ', N'                              ', N'                                                  ', N'                ', N'    ', 0, 0, CAST(N'1900-01-01T00:00:00' AS SmallDateTime), CAST(N'1900-01-01T00:00:00' AS SmallDateTime), 0, N'                              ', N'                              ', N'                    ', N'                    ', N'          ', N'          ', N'    ', 0, CAST(N'1900-01-01T00:00:00' AS SmallDateTime), 0, N'          ', N'          ', N'          ', N'          ', N'          ', 0, N'01                      ', CAST(GETDATE() AS SmallDateTime), N'WEBEMP   ', N'WEBADMIN  ', N'          ', N'          ', N'                                                  ', N' ', 0, N' ', 0, N' ', 8, 40, N' ', N'                              ', N'                              ', 0, 0, N'                                                  ');
										/*ALTA EN TABLA PJEMPPJT PARA CAPTURA DE REPORTES*/
										INSERT [dbo].[PJEMPPJT] 
										([crtd_datetime], [crtd_prog], [crtd_user], [employee], [ep_id01], [ep_id02], [ep_id03], [ep_id04], [ep_id05], [ep_id06], [ep_id07], [ep_id08], [ep_id09], [ep_id10], [effect_date], [labor_class_cd], [labor_rate], [lupd_datetime], [lupd_prog], [lupd_user], [noteid], [project], [user1], [user2], [user3], [user4]) 
										VALUES (CAST(GETDATE() AS SmallDateTime), N'TMEPJ   ', N'WEBSYS  ', @nnomina, N'                              ', N'                              ', N'                ', N'                ', N'HR  ', 0, 0, CAST(N'1900-01-01T00:00:00' AS SmallDateTime), CAST(N'1900-01-01T00:00:00' AS SmallDateTime), 0, CAST(@fechaa AS SmallDateTime), N'MO  ', 1, CAST(GETDATE() AS SmallDateTime), N'TMEPJ   ', N'WEBSYS  ', 0, N'na              ', N'                              ', N'                              ', 0, 0)
										INSERT tbjefe_empleado ([empleado_nomina],[jefe_nomina],[created_by])
										VALUES (@nnomina,@jnomina,@nominaControl)
     COMMIT
 END TRY
 BEGIN CATCH
  ROLLBACK
 END CATCH

 /**ACTUALIZAR SP INSERTAR NUEVO EMPLEADO**/

 /**ACTUALIZAR SP PARA MOSTRAR DATOS**/
 USE [MEXQApppr]
GO
/****** Object:  StoredProcedure [dbo].[datos_empleado_consulta]    Script Date: 08/11/2019 03:37:05 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[datos_empleado_consulta]
@NUMERO_NOMINA VARCHAR(5)
AS 
	BEGIN
		DECLARE @JEFE VARCHAR(5)
		SET @JEFE = (SELECT jefe_nomina FROM tbjefe_empleado WHERE empleado_nomina = @NUMERO_NOMINA)
		SELECT TOP 1 
		te.numero_nomina,te.status,te.id_sucursal,td.clasificacion,td.salario_diario,td.salario_mensual,td.nomina,te.id_celula,te.fecha_alta,td.registro_patronal,
		te.id_puesto,
		CASE WHEN @JEFE IS NULL THEN '' ELSE @JEFE END AS jefe_nomina,
		td.comentarios,te.nombre,te.apellido_paterno,te.apellido_materno,
		CONCAT(te.curpini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.curpfin) AS CURP,
		CONCAT(te.rfcini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.rfcfin) AS RFC,
		te.nss,td.dv,td.lote,te.fecha_nacimiento,td.lugar_nacimiento,te.sexo,td.identificacion,td.numero_identificacion,td.estado_civil,LOWER(td.escolaridad) AS escolaridad,td.constancia,
		td.nombre_padre,td.nombre_madre,td.calle,td.numero_exterior,td.numero_interior,td.codigo_postal,td.estado,
		td.municipio,td.localidad,td.fraccionamiento,UPPER(td.infonavit) AS infonavit,td.numero_infonavit,UPPER(td.fonacot) AS fonacot,td.numero_fonacot,UPPER(td.cuenta) AS cuenta,td.numero_cuenta,
		td.correo,td.telefono,td.celular,td.contacto_emergencia_nombre,td.contacto_emergencia_numero,td.tabulador
		FROM tbempleados AS te
		INNER JOIN tbsucursal AS ts
		ON te.id_sucursal = ts.id_sucursal 
		INNER JOIN tbdatos_empleados AS td
		ON te.numero_nomina = td.numero_nomina
		AND te.numero_nomina = @NUMERO_NOMINA
	END

/**CONSULTA DATOS EMPLEADOS**/
USE [MEXQAPPPR]
GO
/****** Object:  StoredProcedure [dbo].[bajas_diarias]    Script Date: 05/11/2019 08:34:50 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[consulta_datos_empleado]
@NUMERO_NOMINA VARCHAR(5)
AS
	BEGIN
		SELECT
		TOP 1
		CASE WHEN ts.codigo = '99COR0000' THEN ts.codigo
		ELSE tc.codigo END AS 'clave_socio',
		ts.nombre_corto AS sucursal,tc.nombre AS planta,
		CONVERT(VARCHAR(10), te.fecha_alta, 103) AS 'fechaAlta',
		CASE
			WHEN (SELECT id_puesto FROM tbempleados WHERE numero_nomina = te.numero_nomina) < 1
            THEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
            ELSE (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
		END AS puesto,
		td.clasificacion,td.nomina,td.registro_patronal,td.salario_diario,td.lote,
		te.status,te.numero_nomina,UPPER(te.apellido_paterno) AS 'apellidoPaterno',UPPER(te.apellido_materno) AS 'apellidoMaterno',te.nombre AS nombreEmpleado,
		CONVERT(VARCHAR(10), te.fecha_nacimiento, 103) AS fechaNacimiento,td.municipio,td.estado,td.lugar_nacimiento,te.sexo,
		CONCAT(te.rfcini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.rfcfin) AS RFC,
		CONCAT(te.curpini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.curpfin) AS CURP,
		te.nss,td.dv,td.identificacion,td.numero_identificacion,td.estado_civil,UPPER(td.escolaridad) AS escolaridad,
		CASE 
		WHEN CHARINDEX('|', td.nombre_padre, 0) = 0
		THEN td.nombre_padre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_padre, '|', '.'), 3)))
		END AS apellidoPaternoPadre,
		CASE 
		WHEN CHARINDEX('|', td.nombre_padre, 0) = 0
		THEN td.nombre_padre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_padre, '|', '.'), 2)))
		END AS apellidoMaternoPadre,
		CASE 
		WHEN CHARINDEX('|', td.nombre_padre, 0) = 0
		THEN td.nombre_padre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_padre, '|', '.'), 1)))
		END AS nombrePadre,
		UPPER(td.nombre_padre) AS nombre_padre,
		CASE 
		WHEN CHARINDEX('|', td.nombre_madre, 0) = 0
		THEN td.nombre_madre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_madre, '|', '.'), 3)))
		END AS apellidoPaternoMadre,
		CASE 
		WHEN CHARINDEX('|', td.nombre_madre, 0) = 0
		THEN td.nombre_madre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_madre, '|', '.'), 2)))
		END AS apellidoMaternoMadre,
		CASE 
		WHEN CHARINDEX('|', td.nombre_madre, 0) = 0
		THEN td.nombre_madre
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(td.nombre_madre, '|', '.'), 1)))
		END AS nombreMadre,
		UPPER(td.nombre_madre) AS nombre_madre,
		UPPER(td.calle) AS calle,td.numero_exterior,td.numero_interior,UPPER(td.fraccionamiento) AS fraccionamiento,td.codigo_postal,UPPER(td.localidad) AS localidad,UPPER(td.municipio) AS municipio,UPPER(td.estado) AS estado,
		td.cuenta,td.numero_cuenta,td.infonavit,td.numero_infonavit,td.fonacot,td.numero_fonacot,td.correo,td.celular,td.telefono,td.contacto_emergencia_nombre,td.contacto_emergencia_numero,td.lote,td.lote_acuse,td.baja_acuse,td.baja_procesada,te.nombre_largo,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(descripcion, '|', '.'), 3))) 
		END AS c 
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaClasficacion,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(descripcion, '|', '.'), 2)))
		END AS m 
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaMotivo,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(descripcion, '|', '.'), 1)))
		END AS e
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaExplicacion,
		(SELECT comentario FROM tbestado WHERE numero_nomina = te.numero_nomina) AS bajaComentario,
		td.tabulador
		FROM tbempleados AS te
		INNER JOIN tbsucursal AS ts
		ON te.id_sucursal = ts.id_sucursal
		INNER JOIN tbcelula AS tc
		ON tc.id_celula = te.id_celula
		INNER JOIN tbdatos_empleados AS td
		ON td.numero_nomina = te.numero_nomina
		AND te.numero_nomina = @NUMERO_NOMINA
		ORDER BY te.status ASC, te.created_at ASC
	END

	/**CONSULTA DE BAJAS**/
USE [MEXQApppr]
GO
/****** Object:  StoredProcedure [dbo].[bajas_diarias]    Script Date: 05/11/2019 08:34:50 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[bajas_diarias]
@FECHA_BAJA DATE
AS
	BEGIN
		SELECT TOP 200 te.numero_nomina,CONCAT('''',te.nss,td.dv) AS nss,UPPER(te.nombre_largo) AS nombre_largo,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE LEFT(descripcion, CHARINDEX('|', descripcion, 0)-1) END AS c 
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaClasficacion,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE LTRIM(RTRIM(PARSENAME(REPLACE(descripcion, '|', '.'), 2)))
		END AS m 
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaMotivo,
		(SELECT descripcion FROM tbcodigos WHERE codigo = (SELECT 
		CASE 
		WHEN CHARINDEX('|', descripcion, 0) = 0
		THEN descripcion
		ELSE RIGHT(descripcion, CHARINDEX('|', descripcion, 0)-1)
		END AS e 
		FROM tbestado WHERE numero_nomina = te.numero_nomina)) AS bajaExplicacion,
		(SELECT comentario FROM tbestado WHERE numero_nomina = te.numero_nomina) AS bajaComentario,
		td.salario_diario,
		ts.nombre AS sucursal,
		tc.nombre planta,
		CONVERT(VARCHAR(10), te.fecha_baja, 105) AS fechaBaja,
		td.registro_patronal,
		CASE WHEN td.nomina = 'S' THEN 'SEM'
		WHEN td.nomina = 'Q' THEN 'QUIN'
		ELSE 'NA' END AS tipo_nomina,
		CASE
			WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
			THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
			ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
		END AS puesto,
		td.baja_acuse,td.baja_procesada,te.updated_at
		FROM tbempleados AS te
		INNER JOIN tbsucursal AS ts
		ON te.id_sucursal = ts.id_sucursal 
		INNER JOIN tbcelula AS tc
		ON tc.id_celula = te.id_celula
		INNER JOIN tbarea AS ta
		ON ta.codigo = tc.codigo_area
		INNER JOIN tbdatos_empleados AS td
		ON te.numero_nomina = td.numero_nomina
		AND te.status = 'B' AND  CONVERT(VARCHAR(10), te.updated_at, 23) = @FECHA_BAJA AND td.clasificacion <> 'B'
		WHERE NOT EXISTS 
		(SELECT descripcion FROM tbestado WHERE descripcion = 'bpcdp' AND numero_nomina = te.numero_nomina)
		GROUP BY te.numero_nomina,te.numero_nomina,te.nss,td.dv,te.nombre_largo,td.salario_diario,ts.nombre,tc.nombre,te.fecha_baja,td.registro_patronal,td.nomina,td.baja_procesada,te.updated_at,te.puesto_temp,te.id_puesto,td.baja_acuse,te.status
		ORDER BY te.status ASC, te.updated_at DESC
	END


/**ACTUALIZA DATOS DEL EMPLEADO**/
USE [MEXQApppr]
GO
/****** Object:  StoredProcedure [dbo].[updateEmployeeData]    Script Date: 11/11/2019 05:38:26 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[updateEmployeeData](
@nnomina varchar(10), 
@jnomina varchar(5),
@codigo_tabulador varchar(10),
@nlargo varchar(85), 
@nombre varchar(35), 
@apaterno varchar(35),
@amaterno varchar(35),
@sexo varchar(5),
@curpi varchar(25),
@curpf varchar(25),
@rfcini varchar(25),
@rfcfin varchar(25),
@fechan DATE,
@nss varchar(25),
@empleado_status varchar(1),
@fechaa DATE,
@comentario text,
@ids INT,
@ida INT,
@idc INT,
@idp INT,
@clasificacion varchar(8)
,@salarioDiario varchar(25)
,@salarioMensual varchar(25)
,@nomina  varchar(1)
,@registro_patronal  varchar(10)
,@lote  varchar(15)
,@dv  varchar(3)
,@lugar_nacimiento  varchar(45)
,@identificacion  varchar(15)
,@numero_identificacion  varchar(65)
,@estado_civil  varchar(5)
,@escolaridad  varchar(25)
,@constancia  varchar(25)
,@nombre_padre  varchar(65)
,@nombre_madre  varchar(65)
,@calle  varchar(65)
,@numero_interior  varchar(10)
,@numero_exterior  varchar(10)
,@fraccionamiento  varchar(65)
,@domicilio_completo  varchar(65)
,@codigo_postal  varchar(5)
,@estado  varchar(55)
,@municipio  varchar(55)
,@localidad  varchar(55)
,@infonavit  varchar(2)
,@numero_infonavit  varchar(35)
,@fonacot  varchar(2)
,@numero_fonacot  varchar(35)
,@cuenta  varchar(2)
,@numero_cuenta  varchar(35)
,@correo  varchar(55)
,@telefono  varchar(25)
,@celular  varchar(25)
,@contacto_emergencia_nombre  varchar(40)
,@contacto_emergencia_numero  varchar(15)
,@nominaControl varchar(5)
)
AS
BEGIN TRY
BEGIN TRANSACTION
		/**TBDATOS_EMPLEADO**/
		UPDATE [dbo].[tbdatos_empleados]
		   SET [clasificacion] = @clasificacion
			  ,[salario_diario] = @salarioDiario
			  ,[salario_mensual] = @salarioMensual
			  ,[nomina] = @nomina
			  ,[registro_patronal] = @registro_patronal
			  ,[lote] = @lote
			  ,[dv] = @dv
			  ,[lugar_nacimiento] = @lugar_nacimiento
			  ,[identificacion] = @identificacion
			  ,[numero_identificacion] = @numero_identificacion
			  ,[estado_civil] = @estado_civil
			  ,[escolaridad] = @escolaridad
			  ,[constancia] = @constancia
			  ,[nombre_padre] = UPPER(@nombre_padre)
			  ,[nombre_madre] = UPPER(@nombre_madre)
			  ,[calle] = @calle
			  ,[numero_interior] = @numero_interior
			  ,[numero_exterior] = @numero_exterior
			  ,[fraccionamiento] = @fraccionamiento
			  ,[domicilio_completo] = @domicilio_completo
			  ,[codigo_postal] = @codigo_postal
			  ,[estado] = @estado
			  ,[municipio] = @municipio
			  ,[localidad] = @localidad
			  ,[infonavit] = @infonavit
			  ,[numero_infonavit] = @numero_infonavit
			  ,[fonacot] = @fonacot
			  ,[numero_fonacot] = @numero_fonacot
			  ,[cuenta] = @cuenta
			  ,[numero_cuenta] = @numero_cuenta
			  ,[correo] = @correo
			  ,[telefono] = @telefono
			  ,[celular] = @celular
			  ,[contacto_emergencia_nombre] = @contacto_emergencia_nombre
			  ,[contacto_emergencia_numero] = @contacto_emergencia_numero
			  ,[posicion] = 1
			  ,[comentarios] = @comentario
			  ,[tabulador] = @codigo_tabulador
			  ,[updated_at] = GETDATE()
			  ,[updated_by] = @nominaControl
		 WHERE [numero_nomina] = @nnomina
		/**TBEMPLEADOS**/
		UPDATE [dbo].[tbempleados]
		   SET [numero_nomina] = @nnomina
			  ,[nombre_largo] = UPPER(@nlargo)
			  ,[nombre] = UPPER(@nombre)
			  ,[apellido_paterno] = UPPER(@apaterno)
			  ,[apellido_materno] = UPPER(@amaterno)
			  ,[curpini] = @curpi
			  ,[curpfin] = @curpf
			  ,[rfcini] = @rfcini
			  ,[rfcfin] = @rfcfin
			  ,[fecha_nacimiento] = @fechan
			  ,[sexo] = @sexo
			  ,[nss] = @nss
			  ,[fecha_alta] = @fechaa
			  ,[status] = @empleado_status
			  ,[id_sucursal] = @ids
			  ,[id_area] = @ida
			  ,[id_celula] = @idc
			  ,[id_puesto] = @idp
			  ,[updated_at] = GETDATE()
			  ,[updated_by] = @nominaControl
		 WHERE [numero_nomina] = @nnomina
		 IF (NOT EXISTS(SELECT * FROM tbjefe_empleado WHERE empleado_nomina = @nnomina))
		 BEGIN
			INSERT INTO tbjefe_empleado(empleado_nomina,jefe_nomina,created_at,created_by)
			VALUES (@nnomina,@jnomina,GETDATE(),@nominaControl)
		 END
		 ELSE
		 BEGIN
			UPDATE tbjefe_empleado SET [jefe_nomina] = @jnomina, [updated_at] = GETDATE(), [updated_by] = @nominaControl WHERE [empleado_nomina] = @nnomina
		 END
     COMMIT
 END TRY
 BEGIN CATCH
  ROLLBACK
 END CATCH

 /**ALTAS SEMANALES**/
 USE [MEXQApppr]
GO
/****** Object:  StoredProcedure [dbo].[altasSemanales]    Script Date: 11/11/2019 07:11:02 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[altasSemanales]
(
@FECHA_INI DATE,
@FECHA_FIN DATE
)
AS
	BEGIN
		SELECT 
		ts.codigo AS cve_sucursal,ts.nombre AS sucursal,tc.nombre AS planta,tc.codigo AS 'claveSocio',
		CONVERT(VARCHAR(10), te.fecha_alta, 105) AS 'fechaAlta',
		CASE
			WHEN td.tabulador IS NULL THEN 'NA'
			ELSE REPLACE(td.tabulador,'|','') 
		END AS tabulador,
		CASE
			WHEN (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp) IS NULL
			THEN (SELECT nombre FROM tbpuesto WHERE id_puesto = te.id_puesto)
			ELSE (SELECT descripcion FROM PUESTOS_NOMINAS WHERE idpuesto = te.puesto_temp)
		END AS puesto,
		CASE 
			WHEN td.clasificacion = 'O' THEN 'Operativo'
			WHEN td.clasificacion = 'A' THEN 'Administrativo'
			WHEN td.clasificacion = 'AO' THEN 'Administrativo Operativo'
			WHEN td.clasificacion = 'E' THEN 'Especial'
			ELSE 'Becario'
		END AS clasificacion,
		CASE 
			WHEN td.nomina = 'S' THEN 'Semanal'
			WHEN td.nomina = 'Q' THEN 'Quincenal'
		END AS nomina,
		CASE 
			WHEN td.registro_patronal = 'CNO' THEN 'Calidad del Norte'
			ELSE 'SAC'
		END AS registro_patronal,
		td.salario_diario,td.lote,
		te.status,CONCAT('''',te.numero_nomina) AS numero_nomina,UPPER(te.apellido_paterno) AS 'apellidoPaterno',UPPER(te.apellido_materno) AS 'apellidoMaterno',te.nombre AS nombreEmpleado,
		te.fecha_nacimiento AS fechaNacimiento,td.municipio,td.estado,td.lugar_nacimiento,
		CASE 
			WHEN te.sexo = 'F' THEN 'Femenino'
			ELSE 'Masculino'
		END AS sexo,
		CONCAT(te.rfcini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.rfcfin) AS RFC,
		CONCAT(te.curpini + RIGHT(YEAR(te.fecha_nacimiento),2) , FORMAT(te.fecha_nacimiento,'MM') , CONVERT(CHAR(2),te.fecha_nacimiento,103) , te.curpfin) AS CURP,
		CONCAT('''',te.nss,td.dv) AS nss,td.numero_identificacion,
		CASE 
			WHEN td.estado_civil = 'C' THEN 'Casado(a)'
			WHEN td.estado_civil = 'D' THEN 'Divorciado(a)'
			WHEN td.estado_civil = 'S' THEN 'Soltero(a)'
			WHEN td.estado_civil = 'V' THEN 'Viudo(a)'
		END AS estado_civil,
		CASE 
			WHEN td.escolaridad = 'b_tecnico' THEN UPPER('Bachillerato Técnico')
			WHEN td.escolaridad = 'carrera_tecnica' THEN UPPER('Carrera Técnica')
			ELSE UPPER(td.escolaridad)
		END AS escolaridad,
		REPLACE(td.nombre_padre,'|',' ') AS nombre_padre,REPLACE(td.nombre_madre,'|',' ') AS nombre_madre,
		td.calle,td.numero_exterior,td.numero_interior,td.fraccionamiento,td.codigo_postal,td.localidad,td.municipio,td.estado,
		td.cuenta,td.numero_cuenta,td.infonavit,td.numero_infonavit,td.fonacot,td.numero_fonacot,td.correo,td.celular,td.telefono,te.nombre_largo
		FROM tbempleados AS te
		INNER JOIN tbsucursal AS ts
		ON te.id_sucursal = ts.id_sucursal 
		INNER JOIN tbcelula AS tc
		ON tc.id_celula = te.id_celula
		INNER JOIN tbdatos_empleados AS td
		ON td.numero_nomina = te.numero_nomina
		AND te.fecha_alta >= @FECHA_INI AND te.fecha_alta <= @FECHA_FIN
		ORDER BY te.status ASC, te.created_at ASC
	END
