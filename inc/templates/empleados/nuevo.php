<form id="myform">
  <div class="bg-gradient-success p-5 text-white text-center rounded-right">
    <h1>DATOS DE LA EMPRESA</h1>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtNomina">Número de nomina</label>
        <input type="text" class="form-control" id="txtNomina" placeholder="Nomina" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="txtTipo">Tipo</label>
        <input type="text" class="form-control" id="txtTipo" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="txtSucursal">Sucursal</label>
        <select class="form-control" id="txtSucursal"></select>
      </div>
      <div class="form-group col-md-4">
        <label for="txtClasificacion">Clasificación</label>
        <select class="form-control" id="txtClasificacion">
          <option value="" selected >Selecciona una Clasificación</option>
          <option value="A">Administrativo</option>
          <option value="AO">Adm .Operativo</option>
          <option value="O">Operativo</option>
          <option value="E">Especial</option>
          <option value="B">Becario</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtSalarioDiario">Salario Diario</label>
        <input type="text" class="form-control" id="txtSalarioDiario" placeholder="Salario Diario">
      </div>
      <div class="form-group col-md-3">
        <label for="txtSalarioMensual">Salario Mensual</label>
        <input type="text" class="form-control" id="txtSalarioMensual" placeholder="Salario Mensual">
      </div>
      <div class="form-group col-md-3">
        <label for="txtTipoNomina">Nomina</label>
        <select class="form-control" id="txtTipoNomina">
          <option value="" selected>Selecciona Nomina</option>
          <option value="Q">QUIN</option>
          <option value="S">SEM</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="txtCelula">Departamento</label>
        <select class="form-control" id="txtCelula"></select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtfechaAlta">Fecha Alta</label>
        <input type="date" class="form-control" id="txtfechaAlta" value="<?php echo date("Y-m-d"); ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="txtRegistro">Registro</label>
        <select class="form-control" id="txtRegistro">
          <option value="SAC" selected>SAC</option>
          <option value="CNO">CNO</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="txtPuesto">Puesto</label>
        <select class="form-control" id="txtPuesto"></select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtTabClave">Clave Tabulador</label>
        <input type="text" class="form-control" id="txtTabClave" minlength="3" maxlength="3">
      </div>
      <div class="form-group col-md-2">
        <label for="txtTabSucursal">Sucursal Tabulador</label>
        <!--<input type="text" list="txtTabSucursal" class="form-control">
        <datalist id="txtTabSucursal"></datalist>-->
        <select class="form-control" id="txtTabSucursal"></select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtTabNivel">Nivel Tabulador</label>
        <select class="form-control" id="txtTabNivel">
          <option value="" selected>Seleccione una opción</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>

        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtReclutado">Reclutador por</label>
        <select class="form-control text-uppercase" id="txtReclutado">
          <option value="" selected>Seleccione una opción</option>
          <option value="reclutador">Reclutador(a)</option>
          <option value="recomendo">Recomendo</option>
          <option value="outsourcing">Outsourcing</option>
          <option value="lider_moral">Lider Moral</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <div class="form-group campoOutL  d-none">
          <label for="txtout_lm">Nombre</label>
          <input type="text" class="form-control" id="txtout_lm" placeholder="Ingrese Outsourcing / Lider moral...">
        </div>
        <div class="form-group campoRecluatdo d-none">
          <label for="txtReclutador">Reclutado por</label>
          <select class="form-control text-uppercase" id="txtReclutador">
          </select>
        </div>
      </div>
      <div class="form-group col-md-12">
        <label for="txtJefe">Jefe directo</label>
        <select class="form-control text-uppercase" id="txtJefe">
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="txtComentario">Comentarios</label>
        <textarea class="form-control" id="txtComentario" rows="3">Dado de alta en laborales.</textarea>
      </div>
    </div>
  </div>

  <div class="bg-gradient-primary p-5 text-white text-center mt-5 rounded-right">
    <h1>DATOS PERSONALES</h1>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtNombre">Nombre(s)</label>
        <input type="text" class="form-control text-uppercase" id="txtNombre">
      </div>
      <div class="form-group col-md-4">
        <label for="txtPaterno">Apellido Paterno</label>
        <input type="text" class="form-control text-uppercase" id="txtPaterno">
      </div>
      <div class="form-group col-md-4">
        <label for="txtMaterno">Apellido Materno</label>
        <input type="text" class="form-control" id="txtMaterno">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtCURP">CURP</label>
        <input type="text" class="form-control" id="txtCURP">
      </div>
      <div class="form-group col-md-3">
        <label for="txtRFC">RFC</label>
        <input type="text" class="form-control" id="txtRFC" minlength="10" maxlength="10">
      </div>
      <div class="form-group col-md-1">
        <label for="txtHClave">HomoClave</label>
        <input type="text" class="form-control" id="txtHClave" minlength="3" maxlength="3">
      </div>

      <div class="form-group col-md-3">
        <label for="txtNSS">NSS</label>
        <input type="text" class="form-control" id="txtNSS" minlength="10" maxlength="10">
      </div>
      <div class="form-group col-md-1">
        <label for="txtDV">DV</label>
        <input type="text" class="form-control" id="txtDV" minlength="1" maxlength="1">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtfechaNacimiento">Fecha Nacimiento</label>
        <input type="date" class="form-control" id="txtfechaNacimiento" value="<?php echo date("Y-m-d"); ?>">
      </div>
      <div class="form-group col-md-2">
        <label for="txtLnacimiento">Lugar de nacimiento</label>
        <input type="text" class="form-control" id="txtLnacimiento">
      </div>
      <div class="form-group col-md-2">
        <label for="txtGenero">Genero</label>
        <select class="form-control" id="txtGenero">
          <option value="M" selected>Hombre</option>
          <option value="F">Mujer</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtTI">Tipo Identificación</label>
        <select class="form-control" id="txtTI">
          <option value="IFE" selected>INE / IFE</option>
          <option value="PASAPORTE">PASAPORTE</option>
          <option value="CEDULA">CEDULA PROFESIONAL</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtID">Identificación</label>
        <input type="text" class="form-control" id="txtID">
      </div>
      <div class="form-group col-md-2">
        <label for="txtCivil">Estado Civil</label>
        <select class="form-control" id="txtCivil">
          <option value="S" selected>Soltero(a)</option>
          <option value="C">Casado(a)</option>
          <option value="D">Divorciado(a)</option>
          <option value="V">Viudo(a)</option>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="txtEscolaridad">Escolaridad</label>
        <select class="form-control" id="txtEscolaridad">
          <option value="primaria" selected>Primaria</option>
          <option value="secundaria">Secundaria</option>
          <option value="preparatoria">Preparatoria o Bachillerato</option>
          <option value="b_tecnico">Bachillerato Técnico</option>
          <option value="carrera_tecnica">Carrera Técnica</option>
          <option value="tsu">Técnico Superior Universitario</option>
          <option value="licenciatura">Licenciatura</option>
          <option value="posgrado">Posgrado</option>
          <option value="maestria">Maestria</option>
          <option value="doctorado">Doctorado</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="txtStescolaridad">Constancia de escolar</label>
        <select class="form-control" id="txtStescolaridad">
          <option value="constancia" selected>Constancia</option>
          <option value="boleta">Boleta</option>
          <option value="certificado">Certificado</option>
          <option value="titulo">Titulo</option>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtNomp">Nombre(s) del padre</label>
        <input type="text" class="form-control" id="txtNomp">
      </div>
      <div class="form-group col-md-4">
        <label for="txtAPp">Apellido paterno del padre</label>
        <input type="text" class="form-control" id="txtAPp">
      </div>
      <div class="form-group col-md-4">
        <label for="txtAMp">Apellido materno del padre</label>
        <input type="text" class="form-control" id="txtAMp">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtNomm">Nombre(s) de la madre</label>
        <input type="text" class="form-control" id="txtNomm">
      </div>
      <div class="form-group col-md-4">
        <label for="txtAPm">Apellido paterno de la madre</label>
        <input type="text" class="form-control" id="txtAPm">
      </div>
      <div class="form-group col-md-4">
        <label for="txtAMm">Apellido materno de la madre</label>
        <input type="text" class="form-control" id="txtAMm">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="txtCalle">Calle</label>
        <input type="text" class="form-control" id="txtCalle">
      </div>
      <div class="form-group col-md-2">
        <label for="txtNume">Numero exterior</label>
        <input type="text" class="form-control" id="txtNume">
      </div>
      <div class="form-group col-md-2">
        <label for="txtNumi">Numero interior</label>
        <input type="text" class="form-control" id="txtNumi">
      </div>
      <div class="form-group col-md-1">
        <label for="txtCP">CP</label>
        <input type="text" class="form-control" id="txtCP">
      </div>
      <div class="form-group col-md-2">
        <label for="txtEdo">Estado</label>
        <input type="text" class="form-control" id="txtEdo">
      </div>
      <div class="form-group col-md-2">
        <label for="txtMunicipio">Municipio</label>
        <input type="text" class="form-control" id="txtMunicipio">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="txtLocalidad">Localidad</label>
        <input type="text" class="form-control" id="txtLocalidad">
      </div>
      <div class="form-group col-md-6">
        <label for="txtFraccionamiento">Colonia / Fraccionamiento</label>
        <select class="form-control" id="txtFraccionamiento"></select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-1">
        <label for="txtInfonavit">Infonavit</label>
        <select class="form-control" id="txtInfonavit">
          <option value="" selected>---</option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="txtNinfonavit">Número de infonavit</label>
        <input type="text" class="form-control" id="txtNinfonavit">
      </div>
      <div class="form-group col-md-1">
        <label for="txtFonacot">Fonacot</label>
        <select class="form-control" id="txtFonacot">
          <option value="" selected>---</option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="txtNfonacot">Número de fonacot</label>
        <input type="text" class="form-control" id="txtNfonacot">
      </div>
      <div class="form-group col-md-2">
        <label for="txtBanco">Tarjeta</label>
        <select class="form-control" id="txtBanco">
          <option value="" selected>Tramitar tarjeta?</option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtCuenta">Número de cuenta banco</label>
        <input type="text" class="form-control" id="txtCuenta">
      </div>
    </div>

  </div>

  <div class="bg-gradient-success p-5 text-white text-center rounded-right mt-5">
    <h2>Contacto</h2>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtCorreo">Correo electronico</label>
        <input type="mail" class="form-control" id="txtCorreo">
      </div>
      <div class="form-group col-md-4">
        <label for="txtTelefono">Telefono</label>
        <input type="text" class="form-control" id="txtTelefono" maxlength="10" minlength="10" placeholder="4499128686">
      </div>
      <div class="form-group col-md-4">
        <label for="txtCelular">Celular</label>
        <input type="text" class="form-control" id="txtCelular" maxlength="10" minlength="10" placeholder="4499128686">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="txtContacto">Nombre contacto emergencia</label>
        <input type="text" class="form-control" id="txtContacto">
      </div>
      <div class="form-group col-md-6">
        <label for="txtNcontacto">Número contacto de emergencia</label>
        <input type="text" class="form-control" id="txtNcontacto" maxlength="10" minlength="10" placeholder="4499128686">
      </div>
    </div>
  </div>

<div class="bg-gradient-success p-5 text-white text-center rounded-right mt-5">
    <h2>Beneficiarios</h2>
    <h4 class="mt-3">Beneficiario 1</h4>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="beneficiario1_nombre">Nombre completo</label>
            <input type="text" class="form-control" id="beneficiario1_nombre" name="beneficiario1_nombre">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_telefono">Teléfono</label>
            <input type="text" class="form-control" id="beneficiario1_telefono" name="beneficiario1_telefono" maxlength="10" placeholder="4499128686">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_calle">Calle</label>
            <input type="text" class="form-control" id="beneficiario1_calle" name="beneficiario1_calle">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="beneficiario1_numExt">Número exterior</label>
            <input type="text" class="form-control" id="beneficiario1_numExt" name="beneficiario1_numExt">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_numInt">Número interior</label>
            <input type="text" class="form-control" id="beneficiario1_numInt" name="beneficiario1_numInt">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_cp">CP</label>
            <input type="text" class="form-control" id="beneficiario1_cp" maxlength="5" name="beneficiario1_cp">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="beneficiario1_estado">Estado</label>
            <input type="text" class="form-control" id="beneficiario1_estado" name="beneficiario1_estado">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_municipio">Municipio</label>
            <input type="text" class="form-control" id="beneficiario1_municipio" name="beneficiario1_municipio">
        </div>
        <div class="form-group col-md-4">
            <label for="beneficiario1_localidad">Localidad</label>
            <input type="text" class="form-control" id="beneficiario1_localidad" name="beneficiario1_localidad">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="beneficiario1_colonia">Colonia / Fraccionamiento</label>
            <select class="form-control" id="beneficiario1_colonia"></select>
        </div>
    </div>

    <div id="beneficiario2Container">
        <h4 class="mt-4">Beneficiario 2</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="beneficiario2_nombre">Nombre completo</label>
                <input type="text" class="form-control" id="beneficiario2_nombre" name="beneficiario2_nombre">
            </div>
            <div class="form-group col-md-4">
                <label for="beneficiario2_telefono">Teléfono</label>
                <input type="text" class="form-control" id="beneficiario2_telefono" name="beneficiario2_telefono" maxlength="10" placeholder="4499128686">
            </div>
            <div class="form-group col-md-4">
                <label for="beneficiario2_calle">Calle</label>
                <input type="text" class="form-control" id="beneficiario2_calle" name="beneficiario2_calle">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="beneficiario2_numExt">Número exterior</label>
                <input type="text" class="form-control" id="beneficiario2_numExt" name="beneficiario2_numExt">
            </div>
            <div class="form-group col-md-4">
                <label for="beneficiario2_numInt">Número interior</label>
                <input type="text" class="form-control" id="beneficiario2_numInt" name="beneficiario2_numInt">
            </div>
            <div class="form-group col-md-4">
                <label for="beneficiario2_cp">CP</label>
                <input type="text" class="form-control" id="beneficiario2_cp" maxlength="5" name="beneficiario2_cp">
            </div>
        </div>
    
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="beneficiario2_estado">Estado</label>
                <input type="text" class="form-control" id="beneficiario2_estado" name="beneficiario2_estado">
            </div>
            <div class="form-group col-md-4">
                <label for="beneficiario2_municipio">Municipio</label>
                <input type="text" class="form-control" id="beneficiario2_municipio" name="beneficiario2_municipio">
            </div>  
            <div class="form-group col-md-4">
                <label for="beneficiario2_localidad">Localidad</label>
                <input type="text" class="form-control" id="beneficiario2_localidad" name="beneficiario2_localidad">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="beneficiario2_colonia">Colonia / Fraccionamiento</label>
                <select class="form-control" id="beneficiario2_colonia"></select>
            </div>
        </div>
    </div>
</div>
      <hr>
      <button type="submit" class="btn btn-primary btn-block" id="btnGuardarEmpleado">GUARDAR <i class="far fa-save"></i></button>
      <br>
</form>