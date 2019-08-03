    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
        <?php 
            include 'inc/templates/topbar.php';
        ?>

    <div class="row seccionBuscar d-none">
        <div class="col-sm-5 ml-4">
            <div class="input-group mb-10">
                <div class="input-group-prepend">
                    <span class="input-group-text iconSearch" id="inputGroup-sizing-default"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" aria-label="Sizing example input" id="searchBox" aria-describedby="inputGroup-sizing-default" placeholder="Buscar..." autofocus>
                <button class="btn btn-success ml-3 exportTable" title="Exportar tabla"><i class="fas fa-file-excel"></i> Exportar tabla</button>
                <button class="btn btn-info ml-3" id="exportInfo" title="Exportar Base de Datos"><i class="fas fa-database"></i> Exportar Base de Datos </button>
            </div>
        </div>
    </div>

<div class="row toolsDH d-none">
  <div class="col-sm-5 ml-4">
      <div class="input-group mb-10">
          <div class="input-group-prepend">
              <span class="input-group-text iconSearch" id="inputGroup-sizing-default"><i class="fas fa-search"></i></span>
          </div>
          <input type="text" class="form-control searchBox" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Buscar..." autofocus>
          <button class="btn btn-success ml-3 exportTable" title="Exportar tabla"><i class="fas fa-file-excel"></i> Exportar tabla</button>
      </div>
  </div>
</div>