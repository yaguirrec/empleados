<div class="card-body">
  <div class="card-header py-3">
    <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    <hr>
    <div class="form-group text-center">
        <h3>Fecha: <?php echo date("d-m-Y");?></h5>
        <input type="date" class="form-control col-2 offset-5" id="txtFechaN" value="<?php echo date("Y-m-d");?>">
    </div>

    <br>

    <div class="form-group alert-info p-3">
        <h4>Subir imagenes</h4>
        <label for="exampleFormControlFile1">Seleccionar imagenes</label>
        <input type="file" class="form-control-file" id="exampleFormControlFile1">
    </div>


    <div class="row m-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover text-center text-uppercase" cellspacing="4">
                <thead class="font-weight-bold bg-gray-200">
                    <th scope="col">Nómina</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Foto</th>
                </thead>
                <tbody id="imagesTable">
                    <tr>
                        <td>08444</td>
                        <td>CESAR ADOLFO VALENCIANO FONSECA</td>
                        <td>CORPORATIVO</td>
                        <td>SISTEMAS</td>
                        <td><a class="btn btn-sm btnimg" role="button">08444.jpg</a></td>
                    </tr>
                    <tr>
                        <td>02701</td>
                        <td>LUIS ANTONIO PEÑA MORALES</td>
                        <td>CORPORATIVO</td>
                        <td>RH</td>
                        <td><a class="btn btn-sm btnimg" role="button">02701.jpg</a></td>
                    </tr>
                </tbody>
                </table>

                <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
                    <p>No hay información disponible de la fecha seleccionada.</p>
                </div>

            </div>
        </div>
    </div>


    <blockquote class="blockquote">
        <p class="mb-0">Notificaciones</p>
        <footer class="blockquote-footer"><a href="index.php?request=notificaciones">Panel notificaciones</a></footer>
    </blockquote>
  </div>
</div>