<div class="card mx-5 empCard">
  <div class="card-header bg-primary text-white text-center">
    PERFIL DEL EMPLEADO
  </div>
  <div class="card-body">
    <h5 class="card-title">DATOS GENERALES EMPLEADO</h5>

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

    <hr>
      <?php include 'inc/templates/empleados/menu.php'; ?>
    <hr>
    
    <div class="row" id="backButton">
      <a href="javascript:history.back();" class="btn btn-secondary btn-block px-5">Regresar</a>
    </div>

  </div>

</div>