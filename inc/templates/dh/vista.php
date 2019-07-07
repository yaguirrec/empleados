<div class="card-body">
  <div class="card-header py-3">
    <h2 class="m-0 font-weight-bold text-secondary text-center text-uppercase seccionTitulo"></h2>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-3 offset-3">
            <select class="form-control" id="txtMes">
            <option value="0" selected>Elije un mes...</option>
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary btn-block" id="btnObtener"><i class="fas fa-paper-plane"></i> Mostrar</button>
        </div>
      </div>
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
      <div class="h1 spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
      <div class="h1 spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
      <div class="h1 spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">...</span>
      </div>
    </div>

    <div class="alert alert-danger d-none text-uppercase text-center h4" id="alertaM" role="alert">
      No hay información disponible.
    </div>
  </div>
</div>