<div class="card-body">
  <div class="card-header py-3">
    <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-bordered table-hover bg-gray-200 text-center text-uppercase" cellspacing="4">
      
      <thead class="font-weight-bold">
        <tr>
          <th scope="col">Nómina</th>
          <th scope="col">Nombres</th>
          <th scope="col">Sucursal</th>
          <th scope="col">Celula</th>
          <th scope="col" id="colType">...</th>
          <th scope="col" id="colKind">...</th>
          <th scope="col">Dias</th>
        </tr>
      </thead>
      <tbody id="dataTable">
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