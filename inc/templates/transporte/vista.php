<div class="card-body">
  <div class="card-header py-3">
    <h4 class="m-0 font-weight-bold text-center text-uppercase text-secondary seccionTitulo"></h4>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-bordered table-hover text-uppercase" cellspacing="4">

      <thead class="bg-gray-500">
        <tr>
          <th scope="col">Nómina</th>
          <th scope="col">Nombres</th>
          <th scope="col">Fecha Alta</th>
          <th scope="col">Area</th>
          <th scope="col">Estado</th>
          <th scope="col">Localidad</th>
          <th scope="col">CP</th>
          <th scope="col">Dirección</th>
          <!-- <th scope="col">Acciones</th> -->
        </tr>
      </thead>
      <tbody class="bg-gray-200" id="dataTable">

      </tbody>
    </table>   
    
    <div id="loadingIndicator" class="text-center mt-4">
      <div class="h1 spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
      <div class="h1 spinner-grow text-success" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
      <div class="h1 spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
    </div>
    
    <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
      No hay información disponible.
    </div>
  </div>
</div>