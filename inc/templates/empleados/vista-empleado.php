<div class="card mx-5 empCard">
  <div class="card-header bg-primary text-white text-center">
    PERFIL DEL EMPLEADO
  </div>
  <div class="card-body">
    <h5 class="card-title text-center" id="txtTitulo"></h5>
    <div class="row">
      <div class="col-md-1.5">
        <img id="empImagen" class='img-circle'>
      </div>
      <div class="col-md-10">
        <table class="table table-sm text-uppercase card-text" cellspacing="0">
          <tbody>
            <tr>
                <th># Nomina:</th>
                <td><dd id="txtNomina"></dd></td>
                <th>Nombre:</th>
                <td><dd id="txtNombre"></dd></td>
                <th>Puesto:</th>
                <td><dd id="txtPuesto"></dd></td>
            </tr>
            <tr>
                <th>Sucursal:</th>
                <td><dd id="txtSucursal"></dd></td>
                <th>Departamento:</th>
                <td><dd id="txtCelula"></dd></td>
                <th>Estado:</th>
                <td><dd class="statusEmpleado" id="txtStatus"></dd></td>
            </tr>
            <tr>
                <th>Alta:</th>
                <td><dd id="txtAlta"></dd></td>
            </tr>
          </tbody>
        </table>

      <div class="accordion" id="accordionExample">
        <div class="card">
          <div class="card-header" id="headingThree">
            <h2 class="mb-0">
              <button id="mainInfo" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <h4>Detalles <i class="fas fa-chevron-circle-down"></i></h4>
              </button>
            </h2>
          </div>

          
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body"> 

            <div class="row">
                <div class="col-sm"><p id="txtCURP"></p></div>
                <div class="col-sm"><p id="txtRFC"></p></div>
                <div class="col-sm"><p id="txtNSS"></p></div>
                <div class="col-sm"><p id="txtGenero"></p></div>
            </div>
            <div class="row">
                <div class="col-sm"><p id="txtFechaN"></p></div>
                <div class="col-sm"><p id="txtLugarN"></p></div>
                <div class="col-sm"><p id="txtEstadoCivil"></p></div>
                <div class="col-sm"><p id="txtEducacion"></p></div>
            </div>
            <div class="row">
                <div class="col-sm"><p id="txtTabulador"></p></div>
                <div class="col-sm"><p id="txtID"></p></div>
                <div class="col-sm"><p id="txtIDN"></p></div>
            </div>

            <div class="row">
                <div class="col-sm"><p id="txtNombrePadre"></p></div>
                <div class="col-sm"><p id="txtNombreMadre"></p></div>
            </div>

            <div class="row">
                <div class="col-sm"><p id="txtEstado"></p></div>
                <div class="col-sm"><p id="txtMunicipio"></p></div>
                <div class="col-sm"><p id="txtLocalidad"></p></div>
                <div class="col-sm"><p id="txtCP"></p></div>
            </div>

            <div class="row">
                <div class="col-sm"><p id="txtCalle"></p></div>
                <div class="col-sm"><p id="txtNumero"></p></div>
                <div class="col-sm"><p id="txtFraccionamiento"></p></div>
                
            </div>

            <div class="row">
                <div class="col-sm"><p id="txtCuenta"></p></div>
                <div class="col-sm"><p id="txtInfonavit"></p></div>
                <div class="col-sm"><p id="txtFonacot"></p></div>
            </div>

            <div class="row">
                <div class="col-sm"><p id="txtCuenta"></p></div>
                <div class="col-sm"><p id="txtInfonavit"></p></div>
                <div class="col-sm"><p id="txtFonacot"></p></div>
            </div>
    
            <div class="row">
              <div class="col-sm"><p id="txtTelefono"></p></div>
              <div class="col-sm"><p id="txtCelular"></p></div>
              <div class="col-sm text-lowercase"><p id="txtCorreo"></p></div>
            </div>

            <div class="row">
              <div class="col-sm"><p id="txtNombreContacto"></p></div>
              <div class="col-sm"><p id="txtNumeroContacto"></p></div>
            </div>

            <div class="row mt-2">
              <div class="col-sm"><p id="txtAltaAcuse"></p></div>
              <div class="col-sm"><p id="txtAltaProcesada"></p></div>
              <div class="col-sm"><p id="txtBajaAcuse"></p></div>
              <div class="col-sm"><p id="txtBajaProcesada"></p></div>
            </div>
            <div class="row mt-4">
              <div class="col-sm text-center"><p id="txtseccionBaja"></p></div>
            </div>
            <div class="row">
              <div class="col-sm"><p id="txtReingreso"></p></div>
              <div class="col-sm"><p id="txtclasificacionBaja"></p></div>
              <div class="col-sm"><p id="txtmotivoBaja"></p></div>
            </div>
            <div class="row">
              <div class="col-sm"><p id="txtexplicacionBaja"></p></div>
              <div class="col-sm"><p id="txtcomentarioBaja"></p></div>
            </div>


            </div>
          </div>
        </div>
      </div>
      </div>
    </div>

    <br>

  <div class="card-deck panelLaborales laborales coordinadora d-none">
      <?php include 'inc/templates/empleados/menu.php'; ?>
  </div>

  <div class="card-deck panelSeguimiento d-none">
    <div class="col-md-12">
      <?php include 'inc/templates/empleados/seguimiento.php'; ?>
    </div>
  </div>
  
  <hr>
    
    <div class="row btnRegresar" id="backButton">
      <div class="col-md-12">
        <a href="javascript:window.open('','_self').close();" class="btn btn-info btn-block px-5">Cerrar</a>
      </div>
    </div>

  </div>

</div>