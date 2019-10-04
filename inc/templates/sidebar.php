    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center mt-2" href="index.php?request=main">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="img/whiteLogo.png" width="85" alt="Logo MEXQ" class="responsive-img mb-2">
          <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3">Empleados <sup>MEXQ</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <div id="sidePaneAdmin d-none">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active seccionPanel d-none">
        <a class="nav-link" href="index.php?request=main">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Panel de control</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading d-none">
        RRHH
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item rh d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rh" aria-expanded="true" aria-controls="rh">
          <i class="fas fa-users-cog"></i>
          <span>Módulo RRHH</span>
        </a>
        <div id="rh" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones de consulta:</h6>
            <a class="collapse-item" href="index.php?request=empleado">Empleados activos</a>
            <a class="collapse-item" href="index.php?request=bajas">Empleados inactivos</a>
          </div>
        </div>
      </li>

      <li class="nav-item laborales d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laborales" aria-expanded="true" aria-controls="laborales">
          <i class="fas fa-users-cog"></i>
          <span>Módulo Laborales</span>
        </a>
        <div id="laborales" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones de consulta:</h6>
            <a class="collapse-item" href="index.php?request=empleado">Empleados activos</a>
            <a class="collapse-item" href="index.php?request=bajas">Empleados inactivos</a>
            <a class="collapse-item" href="index.php?request=becarios">Becarios</a>
            <hr class="sidebar-divider">
            <h6 class="collapse-header">Administrar registros:</h6>
            <a class="collapse-item" href="index.php?request=alta-empleado">Alta de empleado</a>
            <a class="collapse-item" href="index.php?request=altas">Administrar Altas</a>
            <a class="collapse-item" href="index.php?request=semanales">Altas Semanales</a>
            <hr class="sidebar-divider">
            <!-- <h6 class="collapse-header">Administrar Bajas:</h6> -->
            <!-- <a class="collapse-item" href="index.php?request=alta-empleado">Alta de empleado</a> -->
            <!-- <a class="collapse-item" href="index.php?request=administrarBajas">Administrar Bajas</a> -->
            <!-- <a class="collapse-item" href="index.php?request=semanales">Altas Semanales</a> -->
          </div>
        </div>
      </li>

      <li class="nav-item dh d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dh" aria-expanded="true" aria-controls="dh">
          <i class="fas fa-users-cog"></i>
          <span>Módulo DH</span>
        </a>
        <div id="dh" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones de consulta:</h6>
            <a class="collapse-item" href="index.php?request=fecha2">Antiguedad</a>
            <a class="collapse-item" href="index.php?request=fecha1">Cumpleañeros</a>
          </div>
        </div>
      </li>

      <li class="nav-item transportes d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transportes" aria-expanded="true" aria-controls="transportes">
          <i class="fas fa-users-cog"></i>
          <span>Módulo Transportes</span>
        </a>
        <div id="transportes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones de consulta:</h6>
            <a class="collapse-item" href="index.php?request=direcciones">Transportes</a>
          </div>
        </div>
      </li>

      <li class="nav-item nominas d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#nominas" aria-expanded="true" aria-controls="nominas">
          <i class="fas fa-users-cog"></i>
          <span>Módulo Nóminas</span>
        </a>
        <div id="nominas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones de consulta:</h6>
            <a class="collapse-item" href="index.php?request=empleado">Empleados activos</a>
            <a class="collapse-item" href="index.php?request=bajas">Empleados inactivos</a>
            <hr class="sidebar-divider">
            <h6 class="collapse-header">Administrar registros:</h6>
            <a class="collapse-item" href="index.php?request=altas">Administrar Altas</a>
            <a class="collapse-item" href="index.php?request=semanales">Altas Semanales</a>
          </div>
        </div>
      </li>

      <li class="nav-item capacitacion d-none">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#capacitacion" aria-expanded="true" aria-controls="capacitacion">
          <i class="fas fa-fw fa-cog"></i>
          <span>Módulo Capacitación</span>
        </a>
        <div id="capacitacion" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Modulos</h6>
            <a class="collapse-item" href="index.php?request=puestos">Puestos</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <!-- <hr class="sidebar-divider"> -->

      <!-- Heading -->
      <!-- <div class="sidebar-heading">
        Addons
      </div> -->

      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li> -->

      <!-- Nav Item - Charts -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li> -->

      <!-- Nav Item - Tables -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->

      </div>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

      

    </ul>
    <!-- End of Sidebar -->