<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

<!-- Nav Item - Search Dropdown (Visible Only XS) -->
<!-- <li class="nav-item dropdown no-arrow d-sm-none">
  <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-search fa-fw"></i>
  </a> -->
  <!-- Dropdown - Messages -->
  <!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
    <form class="form-inline mr-auto w-100 navbar-search">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</li> -->
<!-- ELICEWEB -->
<li class="nav-item dropdown no-arrow mt-4">
  <p class="text-uppercase">ELICEWEB <small id="version"></small></p>
</li>

<!-- Nav Item - Alerts -->
<!-- INCLUIR AQUI ALERTAS BREAD alert-pane.php -->

<div class="topbar-divider d-none d-md-block"></div>

<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
  <a class="nav-link dropdown-toggle" href="#" id="menuUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre_usuario ?></span>
    <i class="fas fa-user"></i>
  </a>
  <!-- Dropdown - User Information -->
  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="menuUsuario">
    <a class="dropdown-item" href="#">
      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
      Perfil
    </a>
    <a class="dropdown-item" href="#">
      <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
      Configuraciones
    </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item btnSalir" role="button">
      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Cerrar sesión
    </a>
  </div>
</li>

</ul>

</nav>
<!-- End of Topbar -->