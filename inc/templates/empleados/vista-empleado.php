<div class="card mx-5 empCard">
  <div class="card-header bg-primary text-white text-center">
    PERFIL DEL EMPLEADO
  </div>
  <div class="card-body">
    <h5 class="card-title text-center">DATOS GENERALES EMPLEADO</h5>
    <div class="row">
      <div class="col-md-1.5">
        <img id="empImagen" class='img-circle'>
      </div>
      <div class="col-md-10">
        <table class="table table-sm text-uppercase card-text px-5">
            <tbody>
                <tr>
                    <th>Nomina:</th>
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
                    <td><dd id="txtDepartamento"></dd></td>
                    <th>Celula:</th>
                    <td><dd id="txtCelula"></dd></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>

    <br>

    <div class="col-sm">
      <div class="nav-item row laborales d-none">
        <div class="col-md-12">
          <?php include 'inc/templates/empleados/gafete.php'; ?>
        </div>
      </div>
    <hr>
      <div class="row">
        <div class="nav-item col-md-12">
          <?php include 'inc/templates/empleados/menu.php'; ?>
        </div>
      </div>

    <hr>
    
    <div class="row btnRegresar rh nominas laborales d-none" id="backButton">
      <div class="col-md-12">
        <a href="javascript:history.back();" class="btn btn-secondary btn-block px-5">Regresar</a>
      </div>
    </div>
    </div>

  </div>

</div>