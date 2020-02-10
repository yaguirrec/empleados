<!-- Begin Page Content -->
<div class="container-fluid report">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">PANEL INICIAL</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total de Empleados</div>
              <p class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleados"></p>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Administrativos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleadosA"></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-building fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Administrativos Operativos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleadosAO"></div>
            </div>
            <div class="col-auto">
              <i class="far fa-building fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Operativos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleadosO"></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-industry fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Especiales</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleadosE"></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-shield fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-1">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Becarios</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="txtEmpleadosB"></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Content Row -->

  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary text-uppercase">Control de empleados mensual (<?php echo date("Y"); ?>)</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="chartMensual"></canvas>
          </div>
          <div class="mt-4 text-center small">
          </div>
        </div>
      </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary text-uppercase">Altas y Bajas Diarias</h6>
          <br>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <!-- <div class="row">
                <div class="col-sm-2 offset-sm-10">
                  <label class="mr-sm-2 sr-only" for="diasPrevios">Mostrar</label>
                  <select class="custom-select mr-sm-2" id="diasPrevios">
                    <option value="10">10 dias</option>
                    <option value="20">20 dias</option>
                    <option value="30" selected>30 dias</option>
                    <option value="45">45 dias</option>
                    <option value="60">60 dias</option>
                    <option value="80">80 dias</option>
                  </select>
                </div>
            </div> -->
            <canvas id="chartaltasbajasDiarias"></canvas>
          </div>
          <div class="mt-4 text-center small">
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-lg-12 mb-4">

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Sucursales</h6>
        </div>
        <div class="card-body">
          <div class="pt-4 pb-2" style="width: 100%; height: 25%">
            <canvas id="canvas"></canvas>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

      <!-- Project Card Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Empleados en sucursales</h6>
        </div>
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="chartSucursales"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-4">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary text-uppercase">Gestión Empleados <?php echo date("Y"); ?></h6>
          <br>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="chartEmpleados"></canvas>
          </div>
          <div class="mt-4 text-center small">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-6 mb-4">

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Actualizaciones recientes</h6>
        </div>
        <div class="card-body p-2">
          <div style="width: 100%; height: 25%">
            <div id="tarjeta-actualizacion">
              <div id="datos-recientes">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->