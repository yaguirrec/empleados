<form class="needs-validation" novalidate">
  <div class="bg-gradient-success p-5 text-white text-center rounded-right">
  <h1>DATOS DE LA EMPRESA</h1>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtNomina">Número de nomina</label>
        <input type="text" class="form-control" id="txtNomina" placeholder="Nomina">
      </div>
      <div class="form-group col-md-2">
        <label for="txtTipo">Tipo</label>
        <input type="text" class="form-control" id="txtTipo" placeholder="Alta">
      </div>
      <div class="form-group col-md-4">
        <label for="txtLote">Lote</label>
        <input type="text" class="form-control" id="txtLote" placeholder="Lote" autofocus>
      </div>
      <div class="form-group col-md-4">
        <label for="txtCategoria">Categoria</label>
        <input type="text" class="form-control" id="txtCategoria" placeholder="Categoria">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
          <label for="txtSucursal">Sucursal</label>
          <select class="form-control" id="txtSucursal" required></select>  
      </div>
      <div class="form-group col-md-4">
          <label for="txtClasificacion">Clasificación</label>
          <select class="form-control" id="txtClasificacion">
            <option value="" selected required>Selecciona una Clasificación</option>
            <option value="">Adm .Operativo</option>
            <option value="">Operativo</option>
            <option value="">Administrativo</option>
            <option value="">Especial</option>
          </select>
      </div>
      <div class="form-group col-md-4">
          <label for="txtNomina">Nomina</label>
          <select class="form-control" id="txtNomina">
            <option value="" selected>QUIN</option>
            <option value="">SEM</option>
          </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
          <label for="txtCelula">Celula</label>
          <select class="form-control" id="txtCelula" required></select>  
      </div>
      <div class="form-group col-md-4">
        <label for="txtfechaAlta">Fecha Alta</label>
        <input type="date" class="form-control" id="txtfechaAlta" value="<?php echo date("Y-m-d");?>">
      </div>
      <div class="form-group col-md-4">
          <label for="txtClasificacion">Registro</label>
          <select class="form-control" id="txtClasificacion">
            <option value="" selected>SAC</option>
            <option value="">CNO</option>
          </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
          <label for="txtPuesto">Puesto</label>
          <select class="form-control" id="txtPuesto" required></select>  
      </div>
    </div>
  </div>

  <div class="bg-gradient-primary p-5 text-white text-center mt-5 rounded-right">
    <h1>DATOS PERSONALES</h1>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtNombre">Nombre(s)</label>
        <input type="text" class="form-control" id="txtNombre" required>
      </div>
      <div class="form-group col-md-4">
        <label for="txtPaterno">Apellido Paterno</label>
        <input type="text" class="form-control" id="txtPaterno" required>
      </div>
      <div class="form-group col-md-4">
        <label for="txtMaterno">Apellido Materno</label>
        <input type="text" class="form-control" id="txtMaterno" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="txtCURP">CURP</label>
        <input type="text" class="form-control" id="txtCURP" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="txtRFC">RFC</label>
        <input type="text" class="form-control" id="txtRFC" required>
      </div>
      
      <div class="form-group col-md-3">
        <label for="txtNSS">NSS</label>
        <input type="text" class="form-control" id="txtNSS" required>
      </div>
      <div class="form-group col-md-1">
        <label for="txtDV">DV</label>
        <input type="text" class="form-control" id="txtDV" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="txtfechaNacimiento">Fecha Nacimiento</label>
        <input type="date" class="form-control" id="txtfechaNacimiento" value="<?php echo date("Y-m-d");?>" required>
      </div>
      <div class="form-group col-md-2">
        <label for="txtLnacimiento">Lugar de nacimiento</label>
        <input type="text" class="form-control" id="txtLnacimiento">
      </div>
      <div class="form-group col-md-2">
        <label for="txtGenero">Genero</label>
        <select class="form-control" id="txtGenero">
          <option value="H" selected>Hombre</option>
          <option value="M">Mujer</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtTI">Tipo Identificación</label>
        <select class="form-control" id="txtTI">
          <option value="" selected>INE / IFE</option>
          <option value="">PASAPORTE</option>
          <option value="">CEDULA PROFESIONAL</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="txtID">Identificación</label>
        <input type="text" class="form-control" id="txtID">
      </div>
      <div class="form-group col-md-2">
        <label for="txtCivil">Estado Civil</label>
        <select class="form-control" id="txtCivil">
          <option value="" selected>Soltero(a)</option>
          <option value="">Casado(a)</option>
          <option value="">Divorciado(a)</option>
          <option value="">Viudo(a)</option>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="txtEscolaridad">Escolaridad</label>
        <select class="form-control" id="txtEscolaridad">
          <option value="" selected>Primaria</option>
          <option value="">Secundaria</option>
          <option value="">Preparatoria o Bachillerato</option>
          <option value="">Bachillerato Técnico</option>
          <option value="">Carrera Técnica</option>
          <option value="">Técnico Superior Universitario</option>
          <option value="">Licenciatura</option>
          <option value="">Posgrado</option>
          <option value="">Maestria</option>
          <option value="">Doctorado</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="txtStescolaridad">Estatus de escolaridad</label>
        <select class="form-control" id="txtStescolaridad">
          <option value="" selected>Cursando</option>
          <option value="">Trunca</option>
          <option value="">Terminado</option>
          <option value="">Titulado</option>
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
        <!-- <input type="text" class="form-control" id="txtFraccionamiento"> -->
        <select class="form-control" id="txtFraccionamiento"></select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-1">
        <label for="txtInfonavit">Infonavit</label>
        <select class="form-control" id="txtInfonavit">
          <option value="" selected>SI</option>
          <option value="">NO</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="txtNinfonavit">Número de infonavit</label>
        <input type="text" class="form-control" id="txtNinfonavit">
      </div>
      <div class="form-group col-md-1">
        <label for="txtFonacot">Fonacot</label>
        <select class="form-control" id="txtFonacot">
          <option value="" selected>SI</option>
          <option value="">NO</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="txtNfonacot">Número de fonacot</label>
        <input type="text" class="form-control" id="txtNfonacot">
      </div>
      <div class="form-group col-md-1">
        <label for="txtBanco">Tarjeta</label>
        <select class="form-control" id="txtBanco">
          <option value="" selected>SI</option>
          <option value="">NO</option>
        </select>
      </div>
      <div class="form-group col-md-3">
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
      <div class="form-group col-md-1">
        <label for="txtLada1">Lada</label>
        <input type="text" class="form-control" id="txtLada1">
      </div>
      <div class="form-group col-md-3">
        <label for="txtTelefono">Telefono</label>
        <input type="text" class="form-control" id="txtTelefono">
      </div>
      <div class="form-group col-md-1">
        <label for="txtLada2">Lada</label>
        <input type="text" class="form-control" id="txtLada2">
      </div>
      <div class="form-group col-md-3">
        <label for="txtCelular">Celular</label>
        <input type="text" class="form-control" id="txtCelular">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="txtContacto">Contacto emergencia</label>
        <input type="text" class="form-control" id="txtContacto">
      </div>
      <div class="form-group col-md-6">
        <label for="txtContacton">Contacto número de emergencia</label>
        <input type="text" class="form-control" id="txtContacton">
      </div>
    </div>
  </div>

  <hr>

  <button type="submit" class="btn btn-primary btn-block" id="btnGuardarempleado">GUARDAR <i class="far fa-save"></i></button>
  <br>
</form>