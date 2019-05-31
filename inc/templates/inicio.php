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

    <div class="row seccionBuscar">
        <div class="col-sm-4 ml-4">
            <div class="input-group mb-10">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" aria-label="Sizing example input" id="searchBox" aria-describedby="inputGroup-sizing-default" placeholder="Buscar..." autofocus>
                <!-- <button class="btn btn-success ml-3 exportTable"><i class="fas fa-file-excel" title='Exportar tabla'></i> Exportar</button> -->
            </div>
        </div>
    </div>