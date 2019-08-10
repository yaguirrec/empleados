<div class="card-body">
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    </div>

    <button class="btn btn-success btn-lg m-4" id="btnnPuesto"><i class="fas fa-briefcase"></i> Nuevo Puesto</button>

    <div class="row mb-5 d-none" id="nuevo-puesto">
        <div class="col-md-8 offset-2">
            <?php   include 'puestos_admin.php'; ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover bg-gray-200 text-uppercase" cellspacing="4">
        
        <thead class="font-weight-bold">
            <tr>
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Nivel</th>
            <th scope="col">Fecha Creado</th>
            <th scope="col">Fecha Actualizado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody id="dataTable">
        </tbody>
        </table>

        <!-- <div id="loadingIndicator" class="text-center mt-4">
        <div class="h1 spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">...</span>
        </div>
        <div class="h1 spinner-grow text-success" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">...</span>
        </div>
        <div class="h1 spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">...</span>
        </div>
        </div> -->

        <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
        No hay información disponible.
        </div>
    </div>
</div>