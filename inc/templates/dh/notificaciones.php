<div class="card-body">
  <div class="card-header py-3">
    <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    <hr>
    <div class="form-group text-center">
        <h3>Fecha: <?php echo date("d-m-Y");?></h5>
        <input type="date" class="form-control col-2 offset-5" id="txtFechaN" value="<?php echo date("Y-m-d");?>">
    </div>
    <div class="form-group text-center mt-4">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary mr-4" id="btncumplea">Cumpleaños</button>
            <button type="button" class="btn btn-secondary ml-4" id="btnanti">Antiguedad</button>
        </div>
    </div>

    <div class="row m-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover bg-gray-200 text-center text-uppercase" cellspacing="4">
                <thead class="font-weight-bold">
                    <tr>
                        <th scope="col">Nómina</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Notificacion</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="notificationTable">

                </tbody>
                </table>

                <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                    <p>No hay información disponible de la fecha seleccionada.</p>
                </div>

            </div>
        </div>
    </div>


    <blockquote class="blockquote">
        <p class="mb-0">Imagenes de empleados</p>
        <footer class="blockquote-footer"><a href="index.php?request=imagenes-empleados">Administrar imagenes</a></footer>
    </blockquote>
  </div>
</div>