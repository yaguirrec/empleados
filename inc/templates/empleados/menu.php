<div class="card coordinadora d-none laborales">
  <img src="img/misc/01.jpg" class="card-img-top" height="350" alt="...">
  <div class="card-body">
    <h5 class="card-title">Generar Gafete</h5>
    <p class="card-text">Cargar foto para generar gafete del empleado</p>
    <form>
      <div class="form-group">
        <label for="txtFoto">Fotografia</label>
        <input type="file" class="form-control-file" id="txtFoto">
        <label id="lblImagen" class="text-success">El empleado ya cuenta con imagen</label>
        <div class="alert alert-warning d-none" id="txtGafeteAlerta" role="alert">
          El empleado aun no cuenta con procesada de alta.
        </div>
      </div>
      <div class="d-grid gap-2 d-md-block text-center">
      <button class="btn btn-md btn-primary" id="btnGuardarImagen">Guardar Imagen  <i class="fas fa-file-upload"></i></button>
    </div>
    </form>
  </div>
  <div class="card-footer">
    <div class="d-grid gap-2 d-md-block text-center">
      <h4 class="card-title">Gafetes</h4>
      <button class="btn btn-md btn-info btnGafete" id="btnGafeteQ">QOBRO <i class="fas fa-id-badge"></i></button>
      <button class="btn btn-md btn-success btnGafete" id="btnGafeteM">MEXQ <i class="far fa-id-badge"></i></button>
      <!-- <button class="btn btn-md btn-secondary" id="btnGafeteP">Premium <i class="far fa-id-badge"></i></button> -->
    </div>
  </div>
</div>
<div class="card laborales d-none">
  <img src="img/misc/02.jpg" class="card-img-top" height="350" alt="...">
  <div class="card-body text-center">
    <h5 class="card-title">Administrar Empleado</h5>
    <div class="btn-group-vertical">
      <button class="btn btn-block btn-lg btn-info mb-2" id="btnModificar">Modificar datos</button>
      <button class="btn btn-block btn-lg btn-danger mb-2" id="btnBaja">Dar de baja</button>
      <button class="btn btn-block btn-lg btn-secondary" id="btnCambioPuesto">Cambio de Puesto</button>
    </div>
  </div>
  <div class="card-footer">
    <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
  </div>
</div>
<div class="card">
  <img src="img/misc/03.jfif" class="card-img-top" height="350" alt="...">
  <div class="card-body text-center laborales d-none">
    <h5 class="card-title">Seguimiento</h5>
    <div class="btn-group-vertical">
      <button class="btn btn-block btn-lg btn-info" id="btnSeguimiento">Seguimiento</button>
    </div>
  </div>
</div>
<div class="card">
  <!-- <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
  </div>
  <div class="card-footer">
    <small class="text-muted">Last updated 3 mins ago</small>
  </div> -->
</div>
