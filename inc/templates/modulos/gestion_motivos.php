<div class="card-body">
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase">Motivos de Bajas</h2>
    </div>

    <button class="btn btn-success btn-lg m-4" id="btnNMOT"><i class="fas fa-briefcase"></i> Nuevo motivo</button>

    <div class="table-responsive tablaMotivos">
        <table class="table table-sm table-bordered table-hover bg-gray-200 text-uppercase" cellspacing="4">
        
            <thead class="font-weight-bold">
                <tr>
                <th scope="col">Código</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha creación</th>
                <th scope="col">Creado por</th>
                <th scope="col">Fecha actualizado</th>
                <th scope="col">Actualizado por</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody id="tableMOTBajas">
            </tbody>
        </table>

        <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
        No hay información disponible.
        </div>
    </div>

    <div class="seccionEXP d-none">
        <div class="col-md-8 offset-2">
            <?php include 'gestion_motivos.php'; ?>
        </div>
    </div>

</div>